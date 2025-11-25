<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreVehicleLoanRequest;
use App\Http\Requests\UpdateVehicleLoanRequest;
use App\Models\VehicleLoan;
use App\Models\Employee;
use App\Models\Project;
use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        $loan->vehicle->caracteristicasArray = explode(',', $loan->vehicle->caracteristicas ?? "");
        return view('Gestion_vehiculos.gv_consulta_act_prestamos', ['loan' => $loan, 'vehicle' => $loan->vehicle]);
    }

    public function update(UpdateVehicleLoanRequest $request)
    {
        $data = $request->validated();

        $data['is_on_loan'] = $request->input('is_on_loan') === "SI";

        try {
            // Buscar el prestamo existente.
            $loan = VehicleLoan::findOrFail($request->input('id_loan'));
            $vehicle = $loan->vehicle;

            //Actualizamos a rutas relativas o null del $data.
            for ($i = 1; $i < 6; $i++) {
                $this->update_data_with_file($data, $request, "ruta_evidencia_{$i}", $loan);
            }

            // Intentar actualizar.
            //Transacción por que afectamos varías tablas.
            DB::transaction(function () use ($data, $loan, $vehicle) {
                // Primero actualizar el vehiculo.
                $vehicle->is_on_loan = $data['is_on_loan'];
                $vehicle->km_actual = (int) $data['km_retorno'];
                $vehicle->status = $data['vehicle_status'];
                $vehicle->caracteristicas = $data['caracteristicas'];
                $vehicle->save();

                // Ahora actualizar el prestamo.
                $loan->update([
                    'proveedor' => $data['proveedor'],
                    'status' => $data['prestamo_status'],
                    'fecha_devolucion' => $data['fecha_devolucion'],
                    'km_retorno' => $data['km_retorno'],
                    'ruta_evidencia_1' => $data['ruta_evidencia_1'],
                    'ruta_evidencia_2' => $data['ruta_evidencia_2'],
                    'ruta_evidencia_3' => $data['ruta_evidencia_3'],
                    'ruta_evidencia_4' => $data['ruta_evidencia_4'],
                    'ruta_evidencia_5' => $data['ruta_evidencia_5'],
                    'obs_gral' => $data['prestamo_obs_gral'],
                ]);
            });

            return redirect()->route('vehiculos.consulta_act_prestamos', ['loan' => $loan->id])
                ->with('success', 'Prestamo vehícular actualizado exitosamente ;).');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Si el prestamo vehícular no existe (por manipulación del id).
            return redirect()
                ->back()
                ->withErrors(['id_loan' => 'El prestamo vehícular que intenta actualizar no existe.'])
                ->withInput();
        } catch (\Illuminate\Database\QueryException $e) {
            // Si ocurre un error de base de datos (ej. violación de unique).
            return redirect()
                ->back()
                ->withErrors(['database' => 'Error al actualizar el prestamo vehícular: ' . $e->getMessage()])
                ->withInput();
        } catch (\Exception $e) {
            // Cualquier otro error inesperado.
            return redirect()
                ->back()
                ->withErrors(['general' => 'Ocurrió un error inesperado al actualizar el prestamo vehícular.'])
                ->withInput();
        }
    }

    private function update_data_with_file(array &$data, UpdateVehicleLoanRequest $request, string $key, VehicleLoan $loan)
    {
        // Manejo de archivo solo si se envía.
        if ($request->hasFile($key)) {

            $file = $request->file($key);

            //Borrar el archivo anterior si es que existe. Sí $loan->ruta_evidencia_N != null.

            //Acceso dinámico con -> usando llaves.
            if ($loan->{$key}) {
                Storage::disk('public')->delete($loan->{$key});
            }

            // Nombre seguro y único.
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

            // Guardado en storage/app/public/images_uploaded.
            $path = $file->storeAs('images_uploaded', $filename, 'public');

            // Guardar path en la BD.
            $data[$key] = $path;
        } else {
            $data[$key] = $loan->{$key};
        }
    }
}
