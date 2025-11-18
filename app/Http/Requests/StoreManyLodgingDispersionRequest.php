<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreManyLodgingDispersionRequest extends FormRequest
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
            if (isset($item['rfc_hospedaje'])) {
                $item['rfc_hospedaje'] = trim($item['rfc_hospedaje']);
            }
            if (isset($item['razon_social'])) {
                $item['razon_social'] = trim($item['razon_social']);
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
            '*.rfc_hospedaje' => 'required|string|max:50',
            '*.razon_social' => 'required|string|max:250',
            '*.numero_noches' => 'required|integer|min:0',
            '*.costo_x_noche' => 'required|numeric|min:0',
            '*.numero_personas' => 'required|integer|min:0',
            '*.base_imponible' => 'required|numeric|min:0',
            '*.iva_hospedaje' => 'required|numeric|min:0',
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

            '*.rfc_hospedaje.required' => 'El RFC del hospedaje es obligatorio.',
            '*.rfc_hospedaje.max' => 'El RFC del hospedaje no puede exceder los 50 caracteres.',

            '*.razon_social.required' => 'La razón social es obligatoria.',
            '*.razon_social.max' => 'La razón social no puede exceder los 250 caracteres.',

            '*.numero_noches.required' => 'El número de noches es obligatorio.',
            '*.numero_noches.integer' => 'El número de noches debe ser un número entero.',
            '*.numero_noches.min' => 'El número de noches no puede ser negativo.',

            '*.costo_x_noche.required' => 'El costo por noche es obligatorio.',
            '*.costo_x_noche.numeric' => 'El costo por noche debe ser un valor numérico.',
            '*.costo_x_noche.min' => 'El costo por noche no puede ser negativo.',

            '*.numero_personas.required' => 'El número de personas es obligatorio.',
            '*.numero_personas.integer' => 'El número de personas debe ser un número entero.',
            '*.numero_personas.min' => 'El número de personas no puede ser negativo.',

            '*.base_imponible.required' => 'La base imponible es obligatoria.',
            '*.base_imponible.numeric' => 'La base imponible debe ser un valor numérico.',
            '*.base_imponible.min' => 'La base imponible no puede ser negativa.',

            '*.iva_hospedaje.required' => 'El IVA del hospedaje es obligatorio.',
            '*.iva_hospedaje.numeric' => 'El IVA del hospedaje debe ser un valor numérico.',
            '*.iva_hospedaje.min' => 'El IVA del hospedaje no puede ser negativo.',

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
