<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOneLodgingDispersionRequest;
use App\Http\Requests\StoreManyLodgingDispersionRequest;
use App\Http\Requests\UpdateOneLodgingDispersionRequest;
use Illuminate\Http\Request;
use App\Models\LodgingDispersion;
use Illuminate\Support\Facades\DB;

class LodgingDispersionController extends Controller
{
    public function storeOne(StoreOneLodgingDispersionRequest $request)
    {
        $data = $request->validated();

        try {
            $lodging_dispersion = LodgingDispersion::create($data);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'No se pudo registrar la dispersión de hospedaje: ' . $e->getMessage()])
                ->withInput();
        }

        return redirect()->route('dispersiones.lodging_disp_consulta_act', ['dispersion' => $lodging_dispersion->id])
            ->with('success', 'Dispersión de hospedaje registrada exitosamente ;).');
    }

    public function storeMany(StoreManyLodgingDispersionRequest $request)
    {
        $data = $request->validated(); // array de arrays asociativos.

        try {
            $insertedCount = DB::transaction(function () use ($data) {
                $count = 0;
                foreach ($data as $item) {
                    LodgingDispersion::create($item);
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

    public function show(LodgingDispersion $dispersion)
    {
        return view('Gestion_dispersiones_monetarias.gdm_hospedaje_disp_consulta_act', ['dispersion' => $dispersion]);
    }

    public function update(UpdateOneLodgingDispersionRequest $request)
    {
        $data = $request->validated();

        try {
            // Buscar la dispersión existente.
            $dispersion = LodgingDispersion::findOrFail($request->input('id'));

            // Intentar actualizar.
            $dispersion->update($data);

            return redirect()->route('dispersiones.lodging_disp_consulta_act', ['dispersion' => $dispersion->id])
                ->with('success', 'Dispersión de hospedaje actualizada exitosamente ;).');
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

        $cleanRFCHospedaje = trim($request->input('rfc_hospedaje'));
        $cleanRFCHospedaje = $cleanRFCHospedaje === '' ? null : $cleanRFCHospedaje;

        $request->merge([
            'project_id' => $cleanProjectId,
            'mes' => $cleanMes,
            'rfc_hospedaje' => $cleanRFCHospedaje,
        ]);

        // --- Validación ---
        $data = $request->validate([
            'project_id' => 'nullable|string|exists:projects,id|max:80',
            'mes' => 'nullable|numeric|min:1|max:12',
            'rfc_hospedaje' => 'nullable|string|exists:lodging_dispersions,rfc_hospedaje|max:50',
        ], [
            'project_id.exists' => 'El identificador del proyecto proporcionado no existe en la base de datos.',
            'project_id.max' => 'El identificador del proyecto no puede exceder los 80 caracteres.',

            'mes.numeric' => 'Debes mandar un número de mes válido.',
            'mes.min' => 'El mes debe ser mayor o igual a 1.',
            'mes.max' => 'El mes debe ser menor o igual a 12.',

            'rfc_hospedaje.exists' => 'El RFC del hospedaje proporcionado no existe en la base de datos.',
            'rfc_hospedaje.max' => 'El RFC del hospedaje no puede exceder los 50 caracteres.',
        ]);

        // Validamos aquí para capturar errores y responder JSON sin usar failedValidation() del FormRequest.

        try {
            // --- Construcción dinámica de la consulta ---
            $query = LodgingDispersion::orderBy('fecha_dispersion', 'desc')->limit(50);

            if (!empty($data['project_id'])) {
                $query->where('project_id', $data['project_id']);
            }

            if (!empty($data['mes'])) {
                $query->whereMonth('fecha_dispersion', $data['mes']);
            }

            if (!empty($data['rfc_hospedaje'])) {
                $query->where('rfc_hospedaje', $data['rfc_hospedaje']);
            }

            // --- Ejecución de la consulta ---

            $result = $query->get();

            $result->each(function ($item) {
                $item->fecha_dispersion_string = $item->fecha_dispersion->toDateString();
                $item->project_name = $item->project->nombre;

                $item->makeHidden(['project']); // Esto elimina las relaciones del resultado serializado, pero sin romper el modelo.
            });

            // --- Respuesta ---
            if ($result->isEmpty()) {
                return response()->json(['err' => 'No se encontraron resultados asociados con los filtros proporcionados.'], 404);
            }

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json([
                'err' => 'Error en el sistema SGVAP al consultar las dispersiones de hospedaje: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $lodging_dispersion = LodgingDispersion::findOrFail($id);

            $lodging_dispersion->delete();
        } catch (\Exception $e) {
            return redirect()->route('dispersiones.hospedaje_alta_dispersion')->withErrors(['error' => 'No se pudo eliminar la dispersión de hospedaje: ' . $e->getMessage()]);
        }

        return redirect()->route('dispersiones.hospedaje_alta_dispersion')->with('success', 'Dispersión de hospedaje eliminada exitosamente ;).');
    }
}
