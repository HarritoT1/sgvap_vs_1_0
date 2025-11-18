<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreManyTagDispersionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        // Normaliza cada objeto antes de validar
        $data = collect($this->all())->map(function ($item) {
            if (isset($item['project_id'])) {
                $item['project_id'] = trim(explode('→', $item['project_id'])[0]);
            }

            if (isset($item['vehicle_id'])) {
                $item['vehicle_id'] = trim($item['vehicle_id']);
            }

            if (isset($item['nombre_caseta'])) {
                $item['nombre_caseta'] = trim($item['nombre_caseta']);
            }
            return $item;
        })->toArray();

        $this->replace($data);
    }

    public function rules(): array
    {
        return [
            '*.fecha_dispersion' => 'required|date',
            '*.project_id' => 'required|string|exists:projects,id',
            '*.vehicle_id' => 'required|string|exists:vehicles,id',
            '*.nombre_caseta' => 'required|string|max:100',
            '*.base_imponible' => 'required|numeric|min:0',
            '*.iva_caseta' => 'required|numeric|min:0',
            '*.importe_total' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            '*.fecha_dispersion.required' => 'La fecha de dispersión es obligatoria.',
            '*.fecha_dispersion.date' => 'La fecha de dispersión debe tener un formato válido.',

            '*.project_id.required' => 'El identificador del proyecto es obligatorio.',
            '*.project_id.string' => 'El identificador del proyecto debe ser una cadena de texto.',
            '*.project_id.exists' => 'El proyecto especificado no existe en el sistema.',

            '*.vehicle_id.required' => 'El identificador del vehículo es obligatorio.',
            '*.vehicle_id.string' => 'El identificador del vehículo debe ser una cadena de texto.',
            '*.vehicle_id.exists' => 'El vehículo especificado no existe en el sistema.',

            '*.nombre_caseta.required' => 'El nombre de la caseta es obligatorio.',
            '*.nombre_caseta.max' => 'El nombre de la caseta no puede exceder los 100 caracteres.',

            '*.base_imponible.required' => 'La base imponible es obligatoria.',
            '*.base_imponible.numeric' => 'La base imponible debe ser un valor numérico.',
            '*.base_imponible.min' => 'La base imponible no puede ser negativa.',

            '*.iva_caseta.required' => 'El IVA acumulado es obligatorio.',
            '*.iva_caseta.numeric' => 'El IVA acumulado debe ser un valor numérico.',
            '*.iva_caseta.min' => 'El IVA acumulado no puede ser negativo.',

            '*.importe_total.required' => 'El importe total es obligatorio.',
            '*.importe_total.numeric' => 'El importe total debe ser un valor numérico.',
            '*.importe_total.min' => 'El importe total no puede ser negativo.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Los datos proporcionados no son válidos.',
            'errors' => $validator->errors(),
        ], 422));
    }
}
