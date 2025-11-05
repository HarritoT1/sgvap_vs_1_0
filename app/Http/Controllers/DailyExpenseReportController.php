<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DailyExpenseReport;
use App\Models\Employee;
use App\Models\Project;
use App\Models\ExtraEcoreDebt;

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
}
