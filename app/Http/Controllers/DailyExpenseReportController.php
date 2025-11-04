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
                ], 200);
            }

            return response()->json(['generate' => true, 'with_debt' => false], 200);

        } catch (\Exception $e) { // Manejo de errores generales (DB, ModelNotFound, "ValidationException" => NO, etc.)
            return response()->json([
                'error' => 'Error en el sistema al generar el formulario de reporte de gastos diarios para este empleado en la fecha proporcionada.'
            ], 403);
        }
    }
}
