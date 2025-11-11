<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMonthlyExpenseCutRequest;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\MonthlyExpenseCut;
use App\Models\DailyExpenseReport;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MonthlyExpenseCutController extends Controller
{
    public function generate_data_for_corte_mensual(Request $request)
    {
        // --- Sanitización previa ---
        $cleanEmployeeId = trim(explode('→', $request->input('employee_id'))[0]);
        $request->merge(['employee_id' => $cleanEmployeeId]);

        // --- Validación ---
        $data = $request->validate([
            'employee_id' => 'required|string|exists:employees,id|max:50',
            'mes' => 'required|integer|min:1|max:12',
            'anio' => 'required|integer|min:2000|max:2150',
        ], [
            'employee_id.required' => 'El RFC es obligatorio.',
            'employee_id.exists' => 'El RFC proporcionado no existe en la base de datos.',
            'employee_id.max' => 'El RFC no puede exceder los 50 caracteres.',
            'mes.required' => 'El mes es obligatorio.',
            'mes.integer' => 'Debes mandar un número de mes válido.',
            'mes.min' => 'El mes debe ser mayor o igual a 1.',
            'mes.max' => 'El mes debe ser menor o igual a 12.',
            'anio.required' => 'El año es obligatorio.',
            'anio.integer' => 'Debes mandar un número de año válido.',
            'anio.min' => 'El año debe ser mayor o igual a 2000.',
            'anio.max' => 'El año debe ser menor o igual a 2150.',
        ]);

        try {
            // ---- Validar que el empleado exista y esté activo ----
            $employee = Employee::findOrFail($data['employee_id']);

            if ($employee->status !== 'activo') {
                return back()
                    ->withErrors(['employee_id' => 'El empleado no está activo en el sistema SGVAP.'])
                    ->withInput();
            }

            // ---- Determinar mes y año anterior ----
            $mes_anterior = $data['mes'] == 1 ? 12 : $data['mes'] - 1;
            $anio_anterior = $data['mes'] == 1 ? $data['anio'] - 1 : $data['anio'];
            $mes_anterior_name = Carbon::create()->month($mes_anterior)->locale('es')->monthName;

            // ---- Reutilizar base query para cortes del empleado ----
            $cortesEmpleado = MonthlyExpenseCut::where('employee_id', $data['employee_id']);

            // ---- Si el empleado tiene algún corte previo, validar secuencia ----
            if ($cortesEmpleado->exists()) {
                $faltaCorte = !$cortesEmpleado
                    ->where('mes', $mes_anterior)
                    ->where('anio', $anio_anterior)
                    ->exists();

                if ($faltaCorte) {
                    return back()
                        ->withErrors([
                            'status' => "A este empleado le hace falta el corte mensual del mes {$mes_anterior_name} del año {$anio_anterior}, por favor rectifica su estado anual."
                        ])
                        ->withInput();
                }
            }

            // ---- Validar duplicado ----
            $yaExiste = MonthlyExpenseCut::where('employee_id', $data['employee_id'])
                ->where('mes', $data['mes'])
                ->where('anio', $data['anio'])
                ->exists();

            if ($yaExiste) {
                return back()
                    ->withErrors(['duplicated' => 'El empleado ya tiene un corte mensual registrado para este mes y año.'])
                    ->withInput();
            }

            // Sí todo sale bien generar los datos de la vista del corte mensual del empleado.

            // Obtener los datos de la tabla DailyExpenseReport.

            $cortesDiarios = DailyExpenseReport::where('employee_id', $data['employee_id'])
                ->whereMonth('fecha_dispersion_dia', $data['mes'])
                ->whereYear('fecha_dispersion_dia', $data['anio'])
                ->get();

            $total_alimentos_mes = $cortesDiarios->reduce(function ($c, $n) {
                return $c + (($n->desayuno ?? 0) + ($n->comida ?? 0) + ($n->cena ?? 0));
            }, 0);

            $total_traslado_local_mes = $cortesDiarios->reduce(function ($c, $n) {
                return $c + ($n->traslado_local ?? 0);
            }, 0);

            $total_traslado_externo_mes = $cortesDiarios->reduce(function ($c, $n) {
                return $c + ($n->traslado_externo ?? 0);
            }, 0);

            $total_comision_bancaria_mes = $cortesDiarios->reduce(function ($c, $n) {
                return $c + ($n->comision_bancaria ?? 0);
            }, 0);

            $nombreMes = Str::upper(Carbon::create()->month((int) $data['mes'])->locale('es')->monthName);

            return redirect()->route('empleados.corte_x_mes', ['employee' => $employee->id, 'mes' => $data['mes'], 'mesName' => $nombreMes, 'anio' => $data['anio'], 'total_alimentos_mes' => $total_alimentos_mes, 'total_traslado_local_mes' => $total_traslado_local_mes, 'total_traslado_externo_mes' => $total_traslado_externo_mes, 'total_comision_bancaria_mes' => $total_comision_bancaria_mes]);
        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => 'No se pudo generar el formulario del corte mensual para este empleado: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function show_monthly_cut(Request $request)
    {
        $data = $request->all();
        $data['employee'] = Employee::findOrFail($data['employee']);

        return view('Gestion_empleados/ge_corte_x_mes', $data);
    }

    public function create(StoreMonthlyExpenseCutRequest $request)
    {
        $data = $request->validated();

        try {
            MonthlyExpenseCut::create($data);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'No se pudo registrar el corte mensual del empleado: ' . $e->getMessage()])
                ->withInput();
        }

        return redirect()->route('empleados.consulta_corte_x_año_especifico', ['anio' => $data['anio'], 'employee_id' => $data['employee_id']])
            ->with('success', 'Corte mensual del empleado registrado exitosamente ;).');
    }

    public function show_year_cuts(Request $request)
    {
        // --- Sanitización previa ---
        $cleanEmployeeId = trim(explode('→', $request->input('employee_id'))[0]);
        $request->merge(['employee_id' => $cleanEmployeeId]);

        // --- Validación ---
        $data = $request->validate([
            'employee_id' => 'required|string|exists:employees,id|max:50',
            'anio' => 'required|integer|min:2000|max:2150',
        ], [
            'employee_id.required' => 'El RFC es obligatorio.',
            'employee_id.exists' => 'El RFC proporcionado no existe en la base de datos.',
            'employee_id.max' => 'El RFC no puede exceder los 50 caracteres.',

            'anio.required' => 'El año es obligatorio.',
            'anio.integer' => 'Debes mandar un número de año válido.',
            'anio.min' => 'El año debe ser mayor o igual a 2000.',
            'anio.max' => 'El año debe ser menor o igual a 2150.',
        ]);

        try {
            $monthlyCuts = MonthlyExpenseCut::where('employee_id', $data['employee_id'])
                ->where('anio', $data['anio'])
                ->orderBy('mes', 'asc')
                ->get();

            if ($monthlyCuts->isEmpty()) {
                return redirect()->back()->withErrors(['data' => 'Este empleado no cuenta con cortes mensuales, para este año, no hay resumen que mostrar.'])->withInput();
            }

            $employee = Employee::findOrFail($data['employee_id']);

            $monthlyCuts->each(function ($cut) {
                $cut->mesName = Str::upper(Carbon::create()->month($cut->mes)->locale('es')->monthName);
            });
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'No se pudo generar el resumen anual ' . $data['anio'] . ' del empleado.'])
                ->withInput();
        }

        return view('Gestion_empleados/ge_consulta_corte_x_año_especifico', ['employee' => $employee, 'cuts' => $monthlyCuts, 'anio' => $data['anio']]);
    }

    public function generate_data_for_all_personnel(Request $request)
    {
        try {
            $employee_id_ignore = $request->input('id');
            $anio = $request->input('anio');

            $monthly_cuts_of_all_personnel = MonthlyExpenseCut::where('anio', $anio)
                ->where('employee_id', '!=', $employee_id_ignore)
                ->orderBy('employee_id')
                ->orderBy('mes')
                ->get();

            if ($monthly_cuts_of_all_personnel->isEmpty()) {
                return response()->json([
                    'error' => 'No hay resumenes de cortes anuales disponibles de otros empleados para este año.'
                ], 404);
            }

            $monthly_cuts_of_all_personnel->each(function ($cut) {
                $cut->employee_name = Employee::findOrFail($cut->employee_id)->nombre;
                $cut->mesName = Str::upper(Carbon::create()->month($cut->mes)->locale('es')->monthName);
            });

            return response()->json($monthly_cuts_of_all_personnel, 200);
        } catch (\Exception $e) { // Manejo de errores generales (DB, ModelNotFound, "ValidationException" => NO, etc.)
            return response()->json([
                'error' => 'Error en el sistema SGVAP al consultar los cortes anuales de todo el personal.'
            ], 500);
        }
    }
}
