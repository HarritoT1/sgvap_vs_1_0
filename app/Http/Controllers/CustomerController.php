<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    //
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
}
