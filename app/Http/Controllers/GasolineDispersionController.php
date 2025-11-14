<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOneGasolineDispersionRequest;
use App\Http\Requests\StoreManyGasolineDispersionRequest;
use App\Http\Requests\UpdateOneGasolineDispersionRequest;
use Illuminate\Http\Request;
use App\Models\GasolineDispersion;
use Illuminate\Support\Facades\DB;
use App\Models\Vehicle;

class GasolineDispersionController extends Controller
{
    public function storeOne(StoreOneGasolineDispersionRequest $request)
    {
        $data = $request->validated();

        try {
            $gasoline_dispersion = GasolineDispersion::create($data);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'No se pudo registrar la dispersión de gasolina: ' . $e->getMessage()])
                ->withInput();
        }

        return redirect()->route('dispersiones.gasolina_disp_consulta_act', ['dispersion' => $gasoline_dispersion->id])
            ->with('success', 'Dispersión de gasolina registrada exitosamente ;).');
    }

    public function storeMany(StoreManyGasolineDispersionRequest $request)
    {
        $data = $request->validated(); // array de arrays asociativos.

        try {
            $insertedCount = DB::transaction(function () use ($data) {
                $count = 0;
                foreach ($data as $item) {
                    GasolineDispersion::create($item);
                    $count++;
                }
                return $count; // el valor que devuelve la transacción.
            });
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'errors' => 'Error en el servidor.'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'inserted' => $insertedCount,
        ], 201);
    }

    public function show(GasolineDispersion $dispersion)
    {
        return view('Gestion_dispersiones_monetarias.gdm_gasolina_disp_consulta_act', ['dispersion' => $dispersion, 'vehicles' => Vehicle::all()]);
    }

    public function update(UpdateOneGasolineDispersionRequest $request)
    {
        $data = $request->validated();

        try {
            // Buscar la dispersión existente.
            $dispersion = GasolineDispersion::findOrFail($request->input('id'));

            // Intentar actualizar.
            $dispersion->update($data);

            return redirect()->route('dispersiones.gasolina_disp_consulta_act', ['dispersion' => $dispersion->id])
                ->with('success', 'Dispersión de gasolina actualizada exitosamente ;).');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Si la dispersión no existe (por manipulación del id).
            return redirect()
                ->back()
                ->withErrors(['id' => 'La dispersión que intenta actualizar no existe.'])
                ->withInput();
        } catch (\Illuminate\Database\QueryException $e) {
            // Si ocurre un error de base de datos (ej. violación de unique).
            return redirect()
                ->back()
                ->withErrors(['database' => 'Error al actualizar la dispersión: ' . $e->getMessage()])
                ->withInput();
        } catch (\Exception $e) {
            // Cualquier otro error inesperado.
            return redirect()
                ->back()
                ->withErrors(['general' => 'Ocurrió un error inesperado al actualizar la dispersión.'])
                ->withInput();
        }
    }

    public function find(Request $request)
    {
        // --- Sanitización previa ---
        $cleanProjectId = trim(explode('→', $request->input('project_id'))[0]);
        $cleanProjectId = $cleanProjectId === '' ? null : $cleanProjectId;

        $cleanMes = trim($request->input('mes'));
        $cleanMes = $cleanMes === '' ? null : (float) $cleanMes;

        $cleanVehicleId = trim($request->input('vehicle_id'));
        $cleanVehicleId = $cleanVehicleId === '' ? null : $cleanVehicleId;

        $request->merge([
            'project_id' => $cleanProjectId,
            'mes' => $cleanMes,
            'vehicle_id' => $cleanVehicleId,
        ]);

        // --- Validación ---
        $data = $request->validate([
            'project_id' => 'nullable|string|exists:projects,id|max:80',
            'mes' => 'nullable|numeric|min:1|max:12',
            'vehicle_id' => 'nullable|string|exists:vehicles,id|max:20',
        ], [
            'project_id.exists' => 'El identificador del proyecto proporcionado no existe en la base de datos.',
            'project_id.max' => 'El identificador del proyecto no puede exceder los 80 caracteres.',

            'mes.numeric' => 'Debes mandar un número de mes válido.',
            'mes.min' => 'El mes debe ser mayor o igual a 1.',
            'mes.max' => 'El mes debe ser menor o igual a 12.',

            'vehicle_id.exists' => 'El vehículo proporcionado no existe en la base de datos.',
            'vehicle_id.max' => 'El identificador del vehículo no puede exceder los 20 caracteres.',
        ]);

        // Validamos aquí para capturar errores y responder JSON sin usar failedValidation() del FormRequest.

        try {
            // --- Construcción dinámica de la consulta ---
            $query = GasolineDispersion::orderBy('fecha_dispersion', 'desc')->limit(50);

            if (!empty($data['project_id'])) {
                $query->where('project_id', $data['project_id']);
            }

            if (!empty($data['mes'])) {
                $query->whereMonth('fecha_dispersion', $data['mes']);
            }

            if (!empty($data['vehicle_id'])) {
                $query->where('vehicle_id', $data['vehicle_id']);
            }

            // --- Ejecución de la consulta ---

            $result = $query->get();

            $result->each(function ($item) {
                $item->fecha_dispersion_string = $item->fecha_dispersion->toDateString();
                $item->vehicle_info = $item->vehicle->id . ' → ' . $item->vehicle->marca . ' ' . $item->vehicle->nombre_modelo . ' ' . $item->vehicle->color;
                $item->project_name = $item->project->nombre;

                $item->makeHidden(['vehicle', 'project']); // Esto elimina las relaciones del resultado serializado, pero sin romper el modelo.
            });

            // --- Respuesta ---
            if ($result->isEmpty()) {
                return response()->json(['err' => 'No se encontraron resultados asociados con los filtros proporcionados.'], 404);
            }

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json([
                'err' => 'Error en el sistema SGVAP al consultar las dispersiones de gasolina: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $gasoline_dispersion = GasolineDispersion::findOrFail($id);

            $gasoline_dispersion->delete();
        } catch (\Exception $e) {
            return redirect()->route('dispersiones.gasolina_alta_dispersion')->withErrors(['error' => 'No se pudo eliminar la dispersión de gasolina: ' . $e->getMessage()]);
        }

        return redirect()->route('dispersiones.gasolina_alta_dispersion')->with('success', 'Dispersión de gasolina eliminada exitosamente ;).');
    }
}
