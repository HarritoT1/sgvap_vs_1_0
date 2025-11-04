<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DailyExpenseReport;
use App\Models\Employee;
use App\Models\Project;

class DailyExpenseReportController extends Controller
{
    public function possible_generate_form(Request $request)
    {
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

        // Validar que el empleado exista y sea activo, además, que el registro a crear no exista ya.
        $employee = Employee::findOrFail($data['employee_id']);

        if (!$employee->status == 'activo') {
            return back()->withErrors(['employee_id' => 'El empleado no está activo en el sistema SGVAP.']);
        }

        if (DailyExpenseReport::where('employee_id', $data['employee_id'])
            ->where('fecha_dispersion_dia', $data['fecha_dispersion_dia'])
            ->exists()) {
            return back()->withErrors(['employee_id' => 'Ya existe un reporte de gastos diarios para este empleado en la fecha proporcionada.']);
        }

        // Validar si no hay un registro extra_ecore_debs que deba cobrarse al renderizar el formulario.
        //...

        return response()->json(['generate' => true], 200);
    }
}
