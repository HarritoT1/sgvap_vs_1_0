<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreVehicleLoanRequest;
use App\Models\VehicleLoan;
use App\Models\Employee;
use App\Models\Project;
use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;

class VehicleLoanController extends Controller
{
    public function create(StoreVehicleLoanRequest $request)
    {
        $data = $request->validated();

        try {
            // Validar que el employee_id sea activo, que el project_id sea activo y que el empleado no tenga prestamos en no_entregado (pendientes).

            $employee = Employee::findOrFail($data['employee_id']);
            $project = Project::findOrFail($data['project_id']);
            $vehicle = Vehicle::findOrFail($data['vehicle_id']);

            $data['km_salida'] = $vehicle->km_actual;

            if ($employee->status !== "activo") {
                throw new \Exception('El empleado no esta activo en el sistema SGVAP, selecciona otro empleado o actualiza su estado en el módulo de empleados.');
            }

            if ($project->status !== "activo") {
                throw new \Exception('El proyecto ya esta concluído en el sistema SGVAP, selecciona otro proyecto.');
            }

            if (VehicleLoan::where('employee_id', $data['employee_id'])
                ->where('status', VehicleLoan::STATUS_PENDIENTE)->exists()
            ) {
                throw new \Exception('El empleado tiene un prestamo prendiente, no se le puede prestar otro vehículo, hasta concluír el prestamo anterior.');
            }

            // Ultima validación: El vehiculo no se tiene que encontrar en prestamo.
            if ($vehicle->is_on_loan) {
                throw new \Exception('El vehículo seleccionado se encuentra actualmente en un prestamo vehícular, selecciona otro vehículo.');
            }

            //Transacción por que afectamos varías tablas.
            $loan = DB::transaction(function () use ($data, $vehicle) {
                // Cambiar is_on_loan del vehículo.
                $vehicle->is_on_loan = true;
                $vehicle->save();

                return VehicleLoan::create($data);
            });
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'No se pudo registrar el prestamo vehícular: ' . $e->getMessage()])
                ->withInput();
        }

        return redirect()->route('vehiculos.consulta_act_prestamos', ['loan' => $loan->id])
            ->with('success', 'Prestamo vehícular registrado exitosamente ;).');
    }

    public function show(VehicleLoan $loan)
    {   
        return view('Gestion_vehiculos.gv_consulta_act_prestamos', ['loan' => $loan, 'vehicles' => Vehicle::all(), 'vehicle' => $loan->vehicle, 'employee' => $loan->employee]);
    }
}
