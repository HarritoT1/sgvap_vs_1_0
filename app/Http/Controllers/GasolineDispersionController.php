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
}
