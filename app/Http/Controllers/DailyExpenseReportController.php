<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DailyExpenseReport;
use App\Models\Employee;
use App\Models\Project;
use App\Models\ExtraEcoreDebt;
use App\Http\Requests\StoreDailyExpenseReportRequest;
use Illuminate\Support\Facades\DB;

class DailyExpenseReportController extends Controller
{
    public function possible_generate_form(Request $request)
    {
        $cleanEmployeeId = trim(explode('→', $request->input('employee_id'))[0]);
        $request->merge(['employee_id' => $cleanEmployeeId]);

        // Validar primero (fuera del try).
        $data = $request->validate([
            'employee_id' => 'required|string|exists:employees,id|max:50',
            'fecha_dispersion_dia' => 'required|date',
        ], [
            'employee_id.required' => 'El RFC es obligatorio.',
            'employee_id.exists' => 'El RFC proporcionado no existe en la base de datos.',
            'employee_id.max' => 'El RFC no puede exceder los 50 caracteres.',
            'fecha_dispersion_dia.required' => 'La fecha de corte es obligatoria.',
            'fecha_dispersion_dia.date' => 'La fecha de corte no es una fecha válida.',
        ]);

        try {
            $employee = Employee::findOrFail($data['employee_id']);

            if ($employee->status !== 'activo') {
                return response()->json([
                    'error' => 'El empleado no está activo en el sistema SGVAP.'
                ], 403);
            }

            if (DailyExpenseReport::where('employee_id', $data['employee_id'])
                ->where('fecha_dispersion_dia', $data['fecha_dispersion_dia'])
                ->exists()
            ) {
                return response()->json([
                    'error' => 'Ya existe un reporte de gastos diarios para este empleado en la fecha proporcionada.'
                ], 403);
            }

            $adeudo = ExtraEcoreDebt::where('employee_id', $data['employee_id'])
                ->where('status', 'pendiente')
                ->where('fecha_descontar', '=', $data['fecha_dispersion_dia'])
                ->first();

            if ($adeudo) {
                return response()->json([
                    'generate' => true,
                    'with_debt' => true,
                    'id_extra_ecore_debt' => $adeudo->id,
                    'campo_descontar' => $adeudo->campo_descontar,
                    'monto_extra_ecore' => $adeudo->monto_extra_ecore,
                    'employee_name' => $employee->nombre,
                ], 200);
            }

            return response()->json(['generate' => true, 'with_debt' => false, 'employee_name' => $employee->nombre,], 200);
        } catch (\Exception $e) { // Manejo de errores generales (DB, ModelNotFound, "ValidationException" => NO, etc.)
            return response()->json([
                'error' => 'Error en el sistema al generar el formulario de reporte de gastos diarios para este empleado en la fecha proporcionada.'
            ], 403);
        }
    }

    public function ask_info_about_project(Request $request)
    {
        $query = trim(explode('→', $request->input('q'))[0]);
        $request->merge(['q' => $query]);

        try {
            $project = Project::where('id', 'like', $query . '%')
                ->firstOrFail();

            return response()->json([
                'generacion_progress_bar' => true,
                'project' => [
                    'estimado_viaticos' => $project->estimado_viaticos,
                    'fecha_creacion' => $project->fecha_creacion->toIso8601String(),
                    'fecha_limite' => $project->fecha_limite->toIso8601String(),
                    'nombre' => $project->nombre,
                    'totales_viaticos_table_daily' => [
                        'total_alimentos' => $project->daily_expense_reports->reduce(function ($c, $n) {
                            return $c + (($n->desayuno ?? 0) + ($n->comida ?? 0) + ($n->cena ?? 0));
                        }, 0),
                        'total_traslados' => $project->daily_expense_reports->reduce(function ($c, $n) {
                            return $c + (($n->traslado_local ?? 0) + ($n->traslado_externo ?? 0));
                        }, 0),
                        'total_comision' => $project->daily_expense_reports->reduce(function ($c, $n) {
                            return $c + ($n->comision_bancaria ?? 0);
                        }, 0),
                    ],
                    'totales_viaticos_table_gasoline' => [
                        'total_gasolina' => $project->gasoline_dispersions->reduce(function ($c, $n) {
                            return $c + ($n->monto_dispersado ?? 0);
                        }, 0),
                    ],
                    'totales_viaticos_table_tag' => [
                        'total_caseta' => $project->tag_dispersions->reduce(function ($c, $n) {
                            return $c + ($n->importe_total ?? 0);
                        }, 0),
                    ],
                    'totales_viaticos_lodging' => [
                        'total_hospedaje' => $project->lodging_dispersions->reduce(function ($c, $n) {
                            return $c + ($n->importe_total ?? 0);
                        }, 0),
                    ],
                ],
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'generacion_progress_bar' => false,
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'generacion_progress_bar' => false,
            ], 403);
        }
    }

    public function create(StoreDailyExpenseReportRequest $request)
    {
        $data = $request->validated();

        try {

            /*
                Si falla el insert o save en ExtraEcoreDebt o DailyExpenseReport, ninguno se guarda.
                Si hay error de conexión o findOrFail lanza excepción, todo se revierte.
                Mantiene tus back()->withErrors() intactos, pero en bloque transaccional.
            */
            DB::transaction(function () use ($data, $request) {
                // 1. Validar que el proyecto esté activo.
                $project = Project::findOrFail($data['project_id']);
                if ($project->status !== 'activo') {
                    throw new \Exception('El proyecto seleccionado ya está concluido.');
                }

                $with_ajuste = false;

                // 2. Si viene el registro de un adeudo, validar duplicado.
                if ($request->has('ajuste_retiro')) {
                    $exist = ExtraEcoreDebt::where('employee_id', $data['employee_id'])
                        ->where('campo_descontar', $data['campo_descontar'])
                        ->where('fecha_descontar', $data['fecha_descontar'])
                        ->exists();

                    if ($exist) {
                        throw new \Exception('Ya existe un adeudo creado para el mismo campo a descontar en la misma fecha para este empleado.');
                    }

                    $with_ajuste = true;
                }

                // 3. Si se cobró un adeudo, marcarlo como descontado.
                if ($request->has('id_extra_ecore_debt')) {
                    $adeudo = ExtraEcoreDebt::findOrFail($request->input('id_extra_ecore_debt'));
                    $adeudo->status = 'descontado';
                    $adeudo->save();
                }

                // 4. Registrar el reporte de gastos diarios.
                $daily = DailyExpenseReport::create([
                    'fecha_dispersion_dia' => $data['fecha_dispersion_dia'],
                    'desayuno' => $data['desayuno'] ?? 0,
                    'comida' => $data['comida'] ?? 0,
                    'cena' => $data['cena'] ?? 0,
                    'traslado_local' => $data['traslado_local'] ?? 0,
                    'traslado_externo' => $data['traslado_externo'] ?? 0,
                    'comision_bancaria' => $data['comision_bancaria'] ?? 0,
                    'employee_id' => $data['employee_id'],
                    'project_id' => $data['project_id'],
                ]);

                if ($with_ajuste) {
                    // 5. Registrar el registro de adeudo.
                    ExtraEcoreDebt::create([
                        'employee_id' => $data['employee_id'],
                        'campo_descontar' => $data['campo_descontar'],
                        'monto_extra_ecore' => $data['monto_extra_ecore'],
                        'fecha_descontar' => $data['fecha_descontar'],
                        'daily_expense_report_id' => $daily->id,
                    ]);
                }
            });
        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => 'No se pudo registrar el reporte de gastos diarios: ' . $e->getMessage()])
                ->withInput();
        }

        return redirect()
            ->route('empleados.corte_x_dia')
            ->with('success', 'Reporte de gastos diarios creado exitosamente ;).');
    }

    public function find(Request $request)
    {
        // --- Sanitización previa ---
        $cleanEmployeeId = trim(explode('→', $request->input('employee_id'))[0]);
        $cleanEmployeeId = $cleanEmployeeId === '' ? null : $cleanEmployeeId;

        $cleanMes = trim($request->input('mes'));
        $cleanMes = $cleanMes === '' ? null : (float) $cleanMes;

        $request->merge([
            'employee_id' => $cleanEmployeeId,
            'mes' => $cleanMes,
        ]);

        // --- Validación ---
        $data = $request->validate([
            'employee_id' => 'nullable|string|exists:employees,id|max:50',
            'mes' => 'nullable|numeric|min:1|max:12',
        ], [
            'employee_id.exists' => 'El RFC proporcionado no existe en la base de datos.',
            'employee_id.max' => 'El RFC no puede exceder los 50 caracteres.',
            'mes.numeric' => 'Debes mandar un número de mes válido.',
            'mes.min' => 'El mes debe ser mayor o igual a 1.',
            'mes.max' => 'El mes debe ser menor o igual a 12.',
        ]);

        try {
            // --- Construcción dinámica de la consulta ---
            $query = DailyExpenseReport::orderBy('fecha_dispersion_dia', 'desc')->limit(50);

            if (!empty($data['employee_id'])) {
                $query->where('employee_id', $data['employee_id']);
            }

            if (!empty($data['mes'])) {
                $query->whereMonth('fecha_dispersion_dia', $data['mes']);
            }

            $result = $query->get();

            $result->each(function ($item) {
                $item->fecha_dispersion_dia_string = $item->fecha_dispersion_dia->toDateString();
                $item->employee_name = $item->employee->nombre;
                $item->project_name = $item->project->nombre;

                $item->makeHidden(['employee', 'project']); // Esto elimina las relaciones del resultado serializado, pero sin romper el modelo.
            });

            // --- Respuesta ---
            if ($result->isEmpty()) {
                return response()->json(['err' => 'No se encontraron resultados asociados este empleado.'], 404);
            }

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json([
                'err' => 'Error en el sistema al consultar reportes de gastos diarios: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $report = DailyExpenseReport::findOrFail($id);

                if ($report->extraEcoreDebt) {
                    $report->extraEcoreDebt->delete();
                }

                $report->delete();
            });
        } catch (\Exception $e) {
            return response()->json([
                'err' => 'Error en el sistema al eliminar el reporte de gastos diarios: ' . $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'success' => 'Reporte de gastos diarios eliminado exitosamente.',
        ], 200);
    }

    public function find_semanal(Request $request)
    {
        // --- Sanitización previa ---
        $cleanEmployeeId = trim(explode('→', $request->input('employee_id'))[0]);
        $request->merge(['employee_id' => $cleanEmployeeId]);

        // Validar primero (fuera del try).
        $data = $request->validate([
            'employee_id' => 'required|string|exists:employees,id|max:50',
            'fecha_inicio_semana' => 'required|date|before_or_equal:fecha_fin_semana',
            'fecha_fin_semana' => 'required|date|after_or_equal:fecha_inicio_semana',
        ], [
            'employee_id.required' => 'El RFC es obligatorio.',
            'employee_id.exists' => 'El RFC proporcionado no existe en la base de datos.',
            'employee_id.max' => 'El RFC no puede exceder los 50 caracteres.',
            'fecha_inicio_semana.required' => 'La fecha de inicio de la semana es obligatoria.',
            'fecha_inicio_semana.date' => 'La fecha de inicio de la semana no es una fecha válida.',
            'fecha_inicio_semana.before_or_equal' => 'La fecha de inicio no puede ser posterior a la fecha de fin.',
            'fecha_fin_semana.required' => 'La fecha de fin de la semana es obligatoria.',
            'fecha_fin_semana.date' => 'La fecha de fin de la semana no es una fecha válida.',
            'fecha_fin_semana.after_or_equal' => 'La fecha de fin no puede ser anterior a la de inicio.',
        ]);

        try {
            $employee_name = Employee::findOrFail($data['employee_id'])->nombre;

            $semanal_records = DailyExpenseReport::where('fecha_dispersion_dia', '>=', $data['fecha_inicio_semana'])
                ->where('fecha_dispersion_dia', '<=', $data['fecha_fin_semana'])
                ->where('employee_id', $data['employee_id'])
                ->orderBy('fecha_dispersion_dia', 'asc')
                ->get();

            // --- Respuesta ---
            if ($semanal_records->isEmpty()) {
                return redirect()
                    ->back()
                    ->withErrors(['data' => 'El empleado no tiene ningún registro de reportes de gastos diarios en esta semana.'])
                    ->withInput();
            }

            //dd($semanal_records->isEmpty());

            //dd($semanal_records);

            $total_alimentos = $semanal_records->reduce(function ($c, $n) {
                return $c + (($n->desayuno ?? 0) + ($n->comida ?? 0) + ($n->cena ?? 0));
            }, 0);
            $total_traslados = $semanal_records->reduce(function ($c, $n) {
                return $c + (($n->traslado_local ?? 0) + ($n->traslado_externo ?? 0));
            }, 0);

            $total_comision = $semanal_records->reduce(function ($c, $n) {
                return $c + ($n->comision_bancaria ?? 0);
            }, 0);

            $total_a_retirar = $total_alimentos + $total_traslados + $total_comision;

            return view('Gestion_empleados.ge_retiro_semanal', ['semanal_records' => $semanal_records, 'employee_name' => $employee_name, 'total_alimentos' => $total_alimentos, 'total_traslados' => $total_traslados, 'total_comision' => $total_comision, 'total_a_retirar' => $total_a_retirar]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Si el empleado no existe (por manipulación del id).
            return redirect()
                ->back()
                ->withErrors(['employee_id' => 'El empleado en cuestión no existe.'])
                ->withInput();
        } catch (\Illuminate\Database\QueryException $e) {
            // Si ocurre un error de base de datos (ej. violación de unique).
            return redirect()
                ->back()
                ->withErrors(['database' => 'Error al consultar el retiro semanal del empleado: ' . $e->getMessage()])
                ->withInput();
        } catch (\Exception $e) {
            // Cualquier otro error inesperado.
            return redirect()
                ->back()
                ->withErrors(['general' => 'Ocurrió un error inesperado al consultar el retiro semanal del empleado: ' . $e->getMessage()])
                ->withInput();
        }
    }
}
