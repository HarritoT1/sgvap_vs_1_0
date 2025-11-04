<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Devuelve true si el usuario puede hacer esta acción.
        return true;
    }

    protected function prepareForValidation() {
        // Preparar datos antes de la validación si es necesario.
        $this->merge([
            'id' => trim($this->input('id')),
            'nombre' => trim($this->input('nombre')),
            'puesto' => trim($this->input('puesto')),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'id' => 'required|string|max:50|unique:employees,id,'.$this->input("id_employee"),
            'nombre' => 'required|string|max:100|unique:employees,nombre,'.$this->input("id_employee"),
            'puesto' => 'required|string|max:100',
            'status' => 'required|in:activo,inactivo',
            'modo' => 'required|in:interno,contratista',
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'El RFC del empleado es obligatorio.',
            'id.string' => 'El RFC debe ser una cadena de texto válida.',
            'id.max' => 'El RFC no debe exceder los 50 caracteres.',
            'id.unique' => 'El RFC del empleado ya está registrado.',

            'nombre.required' => 'El nombre del empleado es obligatorio.',
            'nombre.string' => 'El nombre del empleado debe ser una cadena de texto válida.',
            'nombre.max' => 'El nombre no debe exceder los 100 caracteres.',
            'nombre.unique' => 'El nombre del empleado ya está registrado.',

            'puesto.required' => 'El puesto del empleado es obligatorio.',
            'puesto.string' => 'El puesto debe ser una cadena de texto válida.',
            'puesto.max' => 'El puesto no debe exceder los 100 caracteres.',

            'status.required' => 'El estado del empleado es obligatorio.',
            'status.in' => 'El estado debe ser activo o inactivo.',

            'modo.required' => 'El modo del empleado es obligatorio.',
            'modo.in' => 'El modo debe ser interno o contratista.',
        ];
    }
}
