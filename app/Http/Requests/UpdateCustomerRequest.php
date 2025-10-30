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
}
