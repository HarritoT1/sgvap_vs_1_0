<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Models\Customer;

class ProjectController extends Controller
{
    //
    public function create(StoreProjectRequest $request)
    {
        $data = $request->validated();

        try {
            $project = Project::create($data);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'No se pudo crear el proyecto: ' . $e->getMessage()])
                ->withInput();
        }

        return redirect()->route('projects.consulta_act', ['id' => $project->id])
            ->with('success', 'Proyecto creado exitosamente ;).');
    }

    public function show(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|string|exists:projects,id|max:80',
        ], [
            'id.required' => 'El campo id es obligatorio.',
            'id.exists' => 'El id proporcionado no existe en la base de datos.',
            'id.max' => 'El id no puede exceder los 80 caracteres.',
        ]);
        $project = Project::findOrFail($data['id']);
        return view('Gestion_proyectos.gp_consulta_act', ['project' => $project, 'customers' => Customer::all()]);
    }

    public function update(UpdateProjectRequest $request)
    {
        try {
            $data = $request->validated();

            // Buscar el cliente existente.
            $project = Project::findOrFail($request->input('id_project'));

            // Intentar actualizar.
            $project->update($data);

            return redirect()
                ->route('projects.consulta_act', ['id' => $project->id])
                ->with('success', 'Proyecto actualizado exitosamente ;).');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Si el cliente no existe (por manipulación del id).
            return redirect()
                ->back()
                ->withErrors(['id_project' => 'El proyecto que intenta actualizar no existe.'])
                ->withInput();
        } catch (\Illuminate\Database\QueryException $e) {
            // Si ocurre un error de base de datos (ej. violación de unique).
            return redirect()
                ->back()
                ->withErrors(['database' => 'Error al actualizar el cliente: ' . $e->getMessage()])
                ->withInput();
        } catch (\Exception $e) {
            // Cualquier otro error inesperado.
            return redirect()
                ->back()
                ->withErrors(['general' => 'Ocurrió un error inesperado al actualizar el proyecto.'])
                ->withInput();
        }
    }

    public function buscarID(Request $request)
    {
        $query = $request->input('q');

        $projects = Project::where('id', 'like', $query . '%')
            ->limit(10)
            ->get();

        if ($projects->isEmpty()) {
            return response()->json(['message' => 'No se encontraron resultados.'], 404);
        }

        return response()->json($projects);
    }
}
