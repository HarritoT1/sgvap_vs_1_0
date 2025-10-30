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

        $customer = Customer::create($data);

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
        $data = $request->validated();

        $customer = Customer::findOrFail($data['id']);
        $customer->update($data);

        return redirect()->route('clientes.consulta_act', ['id' => $customer->id])
            ->with('success', 'Cliente actualizado exitosamente ;).');
    }
}
