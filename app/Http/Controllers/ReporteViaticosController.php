<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Employee;
use App\Models\Vehicle;
use App\Models\GasolineDispersion;
use App\Models\LodgingDispersion;
use App\Models\TagDispersion;
use Illuminate\Support\Facades\DB;

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

        if ($request->has('year')) {
            $cleanYear = trim($request->input('year'));
            $request->merge(['year' => $cleanYear === '' ? null : $cleanYear]);
        }

        // --- Validación ---
        $data = $request->validate([
            'mes' => 'nullable|integer|min:1|max:12',
            'project_id' => 'nullable|string|exists:projects,id|max:80',
            'employee_id' => 'nullable|string|exists:employees,id|max:50',
            'year' => 'nullable|integer|min:2000|max:2150',
        ], [
            'mes.integer' => 'Debes mandar un número de mes válido.',
            'mes.min' => 'El mes debe ser mayor o igual a 1.',
            'mes.max' => 'El mes debe ser menor o igual a 12.',
            'project_id.exists' => 'El ID del proyecto proporcionado no existe en la base de datos.',
            'project_id.max' => 'El ID del proyecto no puede exceder los 80 caracteres.',
            'employee_id.exists' => 'El RFC proporcionado no existe en la base de datos.',
            'employee_id.max' => 'El RFC no puede exceder los 50 caracteres.',
            'year.integer' => 'Debes mandar un número de año válido.',
            'year.min' => 'El año debe ser mayor o igual a 2000.',
            'year.max' => 'El año debe ser menor o igual a 2150.',
        ]);

        try {
            // --- Llamada a métodos estáticos ya pulidos ---
            $viaticos_por_proyecto = Project::generate_data_graphics_vts(
                $data['mes'] ?? null,
                $data['year'] ?? null,
                $data['project_id'] ?? null
            );

            $viaticos_por_empleado = Employee::generate_data_graphics_vts(
                $data['mes'] ?? null,
                $data['year'] ?? null,
                $data['project_id'] ?? null,
                $data['employee_id'] ?? null
            );
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'El sistema no pudo generar las gráficas de viáticos: ' . $e->getMessage()])
                ->withInput();
        }

        return view('Gestion_empleados.ge_graficas_viaticos', compact('viaticos_por_proyecto', 'viaticos_por_empleado'));
    }

    public function pasteles(Request $request)
    {
        // --- Sanitización previa ---
        if ($request->has('mes')) {
            $cleanMes = trim($request->input('mes'));
            $request->merge(['mes' => $cleanMes === '' ? 0 : (int) $cleanMes]);
        }

        if ($request->has('year')) {
            $cleanYear = trim($request->input('year'));
            $request->merge(['year' => $cleanYear === '' ? 0 : $cleanYear]);
        }

        $personnel_inactive = $request->has('personnel_inactive');
        $proyects_inactive  = $request->has('proyects_inactive');

        // --- Validación ---
        $data = $request->validate([
            'mes' => 'nullable|integer|min:0|max:12',
            'year' => 'nullable|integer|min:0|max:2150',
        ], [
            'mes.integer' => 'Debes mandar un número de mes válido.',
            'mes.min' => 'El mes debe ser mayor o igual a 1.',
            'mes.max' => 'El mes debe ser menor o igual a 12.',
            'year.integer' => 'Debes mandar un número de año válido.',
            'year.min' => 'El año debe ser mayor o igual a 2000.',
            'year.max' => 'El año debe ser menor o igual a 2150.',
        ]);

        try {
            // Llamada a métodos estáticos ya pulidos.
            $data_alimentos = Employee::generate_data_alimentos_pie_graphic($data['mes'] ?? 0, $data['year'] ?? 0, $personnel_inactive);
            $data_tras_local = Employee::generate_data_tras_local_pie_graphic($data['mes'] ?? 0, $data['year'] ?? 0, $personnel_inactive);
            $data_tras_externo = Employee::generate_data_tras_externo_pie_graphic($data['mes'] ?? 0, $data['year'] ?? 0, $personnel_inactive);
            $data_com_bancaria = Employee::generate_data_com_bancaria_pie_graphic($data['mes'] ?? 0, $data['year'] ?? 0, $personnel_inactive);

            $data_gasolina = Project::generate_data_gasolina_pie_graphic($data['mes'] ?? 0, $data['year'] ?? 0, $proyects_inactive);
            $data_caseta = Project::generate_data_caseta_pie_graphic($data['mes'] ?? 0, $data['year'] ?? 0, $proyects_inactive);
            $data_hospedaje = Project::generate_data_hospedaje_pie_graphic($data['mes'] ?? 0, $data['year'] ?? 0, $proyects_inactive);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'El sistema no pudo generar las gráficas por viático: ' . $e->getMessage()])
                ->withInput();
        }

        return view('Gestion_empleados.ge_graficas_x_viatico', compact(
            'data_alimentos',
            'data_tras_local',
            'data_tras_externo',
            'data_com_bancaria',
            'data_gasolina',
            'data_caseta',
            'data_hospedaje'
        ));
    }

    public function barras_gasolina(Request $request)
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

        if ($request->has('vehicle_id')) {
            $cleanVehicleId = trim($request->input('vehicle_id'));
            $request->merge(['vehicle_id' => $cleanVehicleId === '' ? null : $cleanVehicleId]);
        }

        $proyects_inactive  = $request->has('proyects_inactive');

        $data_title_canva_projects = '';
        $data_title_canva_vehicles = '';

        // --- Validación ---
        $data = $request->validate([
            'mes' => 'nullable|integer|min:1|max:12',
            'project_id' => 'nullable|string|exists:projects,id|max:80',
            'vehicle_id' => 'nullable|string|exists:vehicles,id|max:20',
        ], [
            'mes.integer' => 'Debes mandar un número de mes válido.',
            'mes.min' => 'El mes debe ser mayor o igual a 1.',
            'mes.max' => 'El mes debe ser menor o igual a 12.',

            'project_id.exists' => 'El ID del proyecto proporcionado no existe en la base de datos.',
            'project_id.max' => 'El ID del proyecto no puede exceder los 80 caracteres.',

            'vehicle_id.exists' => 'El ID del vehículo proporcionado no existe en la base de datos.',
            'vehicle_id.max' => 'El ID del vehículo no puede exceder los 20 caracteres.',
        ]);

        try {

            // Llamada a métodos estáticos ya pulidos.
            $gasolina_por_proyecto = GasolineDispersion::gas_for_project($data['mes'] ?? null, $data['project_id'] ?? null, $proyects_inactive);

            $gasolina_por_vehiculo = GasolineDispersion::gas_for_vehicle($data['mes'] ?? null, $data['project_id'] ?? null, $data['vehicle_id'] ?? null, $proyects_inactive);

            if (!isset($data['project_id']) && !isset($data['vehicle_id'])) {
                $data_title_canva_projects = 'Todo lo invertido de gasolina en cada proyecto.';

                $data_title_canva_vehicles = 'Todo lo invertido de gasolina en cada vehículo independientemente del proyecto.';

            } else if (isset($data['project_id']) && !isset($data['vehicle_id'])) {
                $project_name = Project::findOrFail($data['project_id'])->nombre;

                $data_title_canva_projects = 'Todo lo invertido de gasolina en el proyecto: ' . $project_name . '.';

                $data_title_canva_vehicles = 'Todo lo invertido de gasolina en cada vehículo del proyecto: ' . $project_name . '.';
                
            } else {
                $project_name = Project::findOrFail($data['project_id'])->nombre;

                $data_title_canva_projects = 'Todo lo invertido de gasolina en el proyecto: ' . $project_name;
                $data_title_canva_vehicles = "Todo lo invertido de gasolina en el vehículo {$data['vehicle_id']} del proyecto: " . $project_name;
            }

            $vehicles = Vehicle::all();

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'El sistema no pudo generar las gráficas de viáticos: ' . $e->getMessage()])
                ->withInput();
        }

        return view('Gestion_dispersiones_monetarias.gdm_graficas_gasolina', compact('gasolina_por_proyecto', 'gasolina_por_vehiculo', 'data_title_canva_projects', 'data_title_canva_vehicles', 'vehicles'));
    }
}
