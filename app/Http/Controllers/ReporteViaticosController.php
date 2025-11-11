<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Employee;

class ReporteViaticosController extends Controller
{
    public function barras(Request $request)
    {
        // --- Sanitización previa ---
        if ($request->has('mes')) {
            $cleanMes = trim($request->input('mes'));
            $request->merge(['mes' => $cleanMes === '' ? null : (int) $cleanMes]);
        }

        if ($request->has('project_id')) {
            $cleanProjectId = trim(explode('→', $request->input('project_id'))[0]);
            $request->merge(['project_id' => $cleanProjectId === '' ? null : $cleanProjectId]);
        }

        if ($request->has('employee_id')) {
            $cleanEmployeeId = trim(explode('→', $request->input('employee_id'))[0]);
            $request->merge(['employee_id' => $cleanEmployeeId === '' ? null : $cleanEmployeeId]);
        }

        // --- Validación ---
        $data = $request->validate([
            'mes' => 'nullable|integer|min:1|max:12',
            'project_id' => 'nullable|string|exists:projects,id|max:80',
            'employee_id' => 'nullable|string|exists:employees,id|max:50',
        ], [
            'mes.integer' => 'Debes mandar un número de mes válido.',
            'mes.min' => 'El mes debe ser mayor o igual a 1.',
            'mes.max' => 'El mes debe ser menor o igual a 12.',
            'project_id.exists' => 'El id del proyecto proporcionado no existe en la base de datos.',
            'project_id.max' => 'El id del proyecto no puede exceder los 80 caracteres.',
            'employee_id.exists' => 'El RFC proporcionado no existe en la base de datos.',
            'employee_id.max' => 'El RFC no puede exceder los 50 caracteres.',
        ]);

        // --- Llamada a métodos estáticos ya pulidos ---
        $viaticos_por_proyecto = Project::generate_data_graphics_vts(
            $data['mes'] ?? null,
            $data['project_id'] ?? null
        );

        $viaticos_por_empleado = Employee::generate_data_graphics_vts(
            $data['mes'] ?? null,
            $data['project_id'] ?? null,
            $data['employee_id'] ?? null
        );

        // --- Retornar a vista o API ---
        return view('reportes.viaticos', compact('viaticos_por_proyecto', 'viaticos_por_empleado'));
    }
}
