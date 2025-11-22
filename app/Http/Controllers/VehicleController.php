<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use Illuminate\Support\Str;
use App\Models\Vehicle;

class VehicleController extends Controller
{
    public function create(StoreVehicleRequest $request)
    {
        $data = $request->validated();

        try {

            // Manejo de archivo solo si se envía
            if ($request->hasFile('ruta_foto_1')) {

                $file = $request->file('ruta_foto_1');

                // Nombre seguro y único
                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

                // Guardado en storage/app/public/images_uploaded
                $path = $file->storeAs('images_uploaded', $filename, 'public');

                // Guardar path en la BD
                $data['ruta_foto_1'] = $path;
            }

            else $data['ruta_foto_1'] = "";

            // Crear vehículo
            $vehicle = Vehicle::create($data);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'No se pudo registrar el vehículo: ' . $e->getMessage()])->withInput();
        }

        return redirect()
            ->route('vehiculos.consulta_act', ['id' => $vehicle->id])
            ->with('success', 'Vehículo registrado exitosamente.');
    }

    public function show(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|string|exists:vehicles,id|max:20',
        ], [
            'id.required' => 'La placa vehicular es obligatorio.',
            'id.exists' => 'La placa vehicular proporcionada no existe en la base de datos.',
            'id.max' => 'La placa vehicular no puede exceder los 20 caracteres.',
        ]);
        $vehicle = Vehicle::findOrFail($data['id']);
        $vehicle->caracteristicasArray = explode(',', $vehicle->caracteristicas);
        dd($vehicle);
        return view('Gestion_vehiculos.gv_consulta_act', ['vehicle' => $vehicle]);
    }
}
