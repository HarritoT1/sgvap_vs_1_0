<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOneGasolineDispersionRequest extends FormRequest
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
            'project_id' => trim(explode('→', $this->input('project_id'))[0]),
        ]);
    }

    public function rules(): array
    {
        return [
            'fecha_dispersion' => 'required|date',
            'project_id' => 'required|string|exists:projects,id',
            'vehicle_id' => 'required|string|exists:vehicles,id',
            'costo_lt' => 'required|numeric|min:0',
            'cant_litros' => 'required|numeric|min:0',
            'monto_dispersado' => 'required|numeric|min:0',
            'base_imponible' => 'required|numeric|min:0',
            'iva_acumulado' => 'required|numeric|min:0',
            'importe_total' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'fecha_dispersion.required' => 'La fecha de dispersión es obligatoria.',
            'fecha_dispersion.date' => 'La fecha de dispersión debe tener un formato válido.',

            'project_id.required' => 'El identificador del proyecto es obligatorio.',
            'project_id.string' => 'El identificador del proyecto debe ser una cadena de texto.',
            'project_id.exists' => 'El proyecto especificado no existe en el sistema.',

            'vehicle_id.required' => 'El identificador del vehículo es obligatorio.',
            'vehicle_id.string' => 'El identificador del vehículo debe ser una cadena de texto.',
            'vehicle_id.exists' => 'El vehículo especificado no existe en el sistema.',

            'costo_lt.required' => 'El costo por litro es obligatorio.',
            'costo_lt.numeric' => 'El costo por litro debe ser un valor numérico.',
            'costo_lt.min' => 'El costo por litro no puede ser negativo.',

            'cant_litros.required' => 'La cantidad de litros es obligatoria.',
            'cant_litros.numeric' => 'La cantidad de litros debe ser un valor numérico.',
            'cant_litros.min' => 'La cantidad de litros no puede ser negativa.',

            'monto_dispersado.required' => 'El monto dispersado es obligatorio.',
            'monto_dispersado.numeric' => 'El monto dispersado debe ser un valor numérico.',
            'monto_dispersado.min' => 'El monto dispersado no puede ser negativo.',

            'base_imponible.required' => 'La base imponible es obligatoria.',
            'base_imponible.numeric' => 'La base imponible debe ser un valor numérico.',
            'base_imponible.min' => 'La base imponible no puede ser negativa.',

            'iva_acumulado.required' => 'El IVA acumulado es obligatorio.',
            'iva_acumulado.numeric' => 'El IVA acumulado debe ser un valor numérico.',
            'iva_acumulado.min' => 'El IVA acumulado no puede ser negativo.',

            'importe_total.required' => 'El importe total es obligatorio.',
            'importe_total.numeric' => 'El importe total debe ser un valor numérico.',
            'importe_total.min' => 'El importe total no puede ser negativo.',
        ];
    }
}
