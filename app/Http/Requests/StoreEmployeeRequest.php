<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Devuelve true si el usuario puede hacer esta acción.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'id' => 'required|string|max:50|unique:employees,id',
            'nombre' => 'required|string|max:100|unique:employees,nombre',
            'puesto' => 'required|string|max:100',
            'modo' => 'required|in:interno,contratista',
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'El RFC del empleado es obligatorio.',
            'id.string' => 'El RFC debe ser una cadena de texto válida.',
            'id.max' => 'El RFC no debe exceder los 50 caracteres.',
            'id.unique' => 'El RFC ya se encuentra registrado.',

            'nombre.required' => 'El nombre del empleado es obligatorio.',
            'nombre.string' => 'El nombre debe ser una cadena de texto válida.',
            'nombre.max' => 'El nombre no debe exceder los 100 caracteres.',
            'nombre.unique' => 'El nombre del empleado ya está registrado.',

            'puesto.required' => 'El puesto del empleado es obligatorio.',
            'puesto.string' => 'El puesto debe ser una cadena de texto válida.',
            'puesto.max' => 'El puesto no debe exceder los 100 caracteres.',

            'modo.required' => 'El modo de contratación es obligatorio.',
            'modo.in' => 'El modo debe ser "interno" o "contratista".',
        ];
    }
}
