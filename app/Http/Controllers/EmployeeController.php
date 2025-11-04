<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;

class EmployeeController extends Controller
{
    //
    public function create(StoreEmployeeRequest $request)
    {
        $data = $request->validated();

        try {
            $employee = Employee::create($data);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'No se pudo crear el empleado: ' . $e->getMessage()])
                ->withInput();
        }

        return redirect()->route('empleados.consulta_act', ['id' => $employee->id])
            ->with('success', 'Empleado creado exitosamente ;).');
    }

    public function show(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|string|exists:employees,id|max:50',
        ], [
            'id.required' => 'El RFC es obligatorio.',
            'id.exists' => 'El RFC proporcionado no existe en la base de datos.',
            'id.max' => 'El RFC no puede exceder los 50 caracteres.',
        ]);
        $employee = Employee::findOrFail($data['id']);
        return view('Gestion_empleados.ge_consulta_act', ['employee' => $employee]);
    }

    public function update(UpdateEmployeeRequest $request)
    {
        $data = $request->validated();
        
        try {
            // Buscar el empleado existente.
            $employee = Employee::findOrFail($request->input('id_employee'));

            // Intentar actualizar.
            $employee->update($data);

            return redirect()
                ->route('empleados.consulta_act', ['id' => $employee->id])
                ->with('success', 'Empleado actualizado exitosamente ;).');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Si el empleado no existe (por manipulación del id).
            return redirect()
                ->back()
                ->withErrors(['id_employee' => 'El empleado que intenta actualizar no existe.'])
                ->withInput();
        } catch (\Illuminate\Database\QueryException $e) {
            // Si ocurre un error de base de datos (ej. violación de unique).
            return redirect()
                ->back()
                ->withErrors(['database' => 'Error al actualizar el empleado: ' . $e->getMessage()])
                ->withInput();
        } catch (\Exception $e) {
            // Cualquier otro error inesperado.
            return redirect()
                ->back()
                ->withErrors(['general' => 'Ocurrió un error inesperado al actualizar el empleado.'])
                ->withInput();
        }
    }

    public function buscarRFC(Request $request)
    {
        $query = $request->input('q');

        $employees = Employee::where('id', 'like', $query . '%')
            ->limit(10)
            ->get();

        if ($employees->isEmpty()) {
            return response()->json(['message' => 'No se encontraron resultados.'], 404);
        }

        return response()->json($employees);
    }
}
