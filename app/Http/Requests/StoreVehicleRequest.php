<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleRequest extends FormRequest
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

    protected function prepareForValidation()
    {
        $this->merge([
            'id' => trim($this->input('id')),
            'nombre_modelo' => trim($this->input('modelo')),
            'marca' => trim($this->input('marca')),
            'color' => trim($this->input('color')),

            'obs_gral' => $this->emptyToNull($this->input('obs_gral')),
        ]);
    }

    /**
     * Convierte cadenas vacías a null.
     */
    private function emptyToNull($value)
    {
        return trim($value) === '' ? null : $value;
    }

    public function rules()
    {
        return [
            'id' => 'required|string|max:20|unique:vehicles,id',
            'nombre_modelo' => 'required|string|max:50',
            'marca' => 'required|string|max:50',
            'anio' => 'required|integer|min:1900|max:2150',
            'color' => 'required|string|max:50',
            'ruta_foto_1' => 'nullable|mimes:png,jpeg,jpg,webp,gif|max:5120',
            'km_actual' => 'required|integer|min:0',
            'obs_gral' => 'nullable|string|max:500',
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'La placa del vehículo es obligatorio.',
            'id.unique' => 'La placa del vehículo ya existe.',
            'id.max' => 'La placa no debe exceder los 20 caracteres.',

            'nombre_modelo.required' => 'El nombre del modelo es obligatorio.',
            'nombre_modelo.max' => 'El nombre del modelo no debe exceder los 50 caracteres.',

            'marca.required' => 'La marca es obligatoria.',
            'marca.max' => 'La marca no debe exceder los 50 caracteres.',

            'anio.required' => 'El año es obligatorio.',
            'anio.integer' => 'El año debe ser un número entero válido.',
            'anio.min' => 'El año no puede ser menor a 1900.',
            'anio.max' => 'El año no puede ser mayor a 2150.',

            'color.required' => 'El color es obligatorio.',
            'color.max' => 'El color no debe exceder los 50 caracteres.',

            'ruta_foto_1.mimes' => 'El formato de la foto no es válido.',
            'ruta_foto_1.max'   => 'La foto no debe exceder los 5 MB.',

            'km_actual.required' => 'El kilometraje actual es obligatorio.',
            'km_actual.integer' => 'El kilometraje actual debe ser un número entero válido.',
            'km_actual.min' => 'El kilometraje actual no puede ser negativo.',

            'obs_gral.max' => 'Las observaciones generales no deben exceder los 500 caracteres.',
        ];
    }
}
