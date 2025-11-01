<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Http\Requests\StoreCutomerRequest;
use App\Http\Requests\UpdateCustomerRequest;

class CustomerController extends Controller
{
    //
    public function create(StoreCutomerRequest $request)
    {
        $data = $request->validated();

        try {
            $customer = Customer::create($data);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'No se pudo crear el cliente: ' . $e->getMessage()])
                ->withInput();
        }

        return redirect()->route('clientes.consulta_act', ['id' => $customer->id])
            ->with('success', 'Cliente creado exitosamente ;).');
    }

    public function show(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|string|exists:customers,id|max:50',
        ], [
            'id.required' => 'El campo RFC es obligatorio.',
            'id.exists' => 'El RFC proporcionado no existe en la base de datos.',
            'id.max' => 'El RFC no puede exceder los 50 caracteres.',
        ]);
        $customer = Customer::findOrFail($data['id']);
        return view('Gestion_clientes.gc_consulta_act', ['customer' => $customer]);
    }

    public function update(UpdateCustomerRequest $request)
    {
        try {
            $data = $request->validated();

            // Buscar el cliente existente.
            $customer = Customer::findOrFail($request->input('id_customer'));

            // Intentar actualizar.
            $customer->update($data);

            return redirect()
                ->route('clientes.consulta_act', ['id' => $customer->id])
                ->with('success', 'Cliente actualizado exitosamente ;).');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Si el cliente no existe (por manipulación del id).
            return redirect()
                ->back()
                ->withErrors(['id_customer' => 'El cliente que intenta actualizar no existe.'])
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
                ->withErrors(['general' => 'Ocurrió un error inesperado al actualizar el cliente.'])
                ->withInput();
        }
    }

    public function buscarRFC(Request $request)
    {
        $query = $request->input('q');

        $customers = Customer::where('id', 'like', $query . '%')
            ->limit(10)
            ->get();

        if ($customers->isEmpty()) {
            return response()->json(['message' => 'No se encontraron resultados.'], 404);
        }

        return response()->json($customers);
    }
}
