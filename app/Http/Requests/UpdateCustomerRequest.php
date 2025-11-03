<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        // Devuelve true si el usuario puede hacer esta acción.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'required|string|max:50|unique:customers,id,' . $this->input('id_customer'),
            'razon_social' => 'required|string|max:200|unique:customers,razon_social,' . $this->input('id_customer'),
            'ubicacion' => 'required|string|max:300',
            'status' => 'required|in:activo,inactivo',
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'El campo RFC es obligatorio.',
            'id.unique' => 'El RFC ya existe en la base de datos.',
            'id.max' => 'El RFC no puede exceder los 50 caracteres.',

            'razon_social.required' => 'El campo Razón Social es obligatorio.',
            'razon_social.unique' => 'La Razón Social ya existe en la base de datos.',
            'razon_social.max' => 'La Razón Social no puede exceder los 200 caracteres.',

            'ubicacion.required' => 'El campo Ubicación es obligatorio.',
            'ubicacion.max' => 'La Ubicación no puede exceder los 300 caracteres.',

            'status.required' => 'El campo status es obligatorio.',
            'status.in' => 'El campo status no es válido.',
        ];
    }
}
