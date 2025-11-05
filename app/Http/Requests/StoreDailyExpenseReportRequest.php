<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDailyExpenseReportRequest extends FormRequest
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
            // Preparar y sanitizar los datos antes de la validación si es necesario.
            "desayuno" => $this->emptyToNull($this->input('desayuno')),
            "comida" => $this->emptyToNull($this->input('comida')),
            "cena" => $this->emptyToNull($this->input('cena')),
            "traslado_local" => $this->emptyToNull($this->input('traslado_local')),
            "traslado_externo" => $this->emptyToNull($this->input('traslado_externo')),
            "comision_bancaria" => $this->emptyToNull($this->input('comision_bancaria')),

            "monto_extra_ecore" => $this->emptyToNull($this->input('monto_extra_ecore')),
            "fecha_descontar" => $this->emptyToNull($this->input('fecha_descontar')),

            'employee_id' => trim(explode('→', $this->input('employee_id'))[0]),
            'project_id' => trim(explode('→', $this->input('project_id'))[0]),
        ]);

        if ($this->has('ajuste_retiro')) {
            $this->merge(['ajuste_retiro' => (bool) $this->input('ajuste_retiro'),]);
        }
    }

    /**
     * Convierte cadenas vacías a null.
     */
    private function emptyToNull($value)
    {
        return trim($value) === '' ? null : $value;
    }

    public function rules(): array
    {
        return [
            'fecha_dispersion_dia' => 'required|date',

            'desayuno' => 'nullable|numeric',
            'comida' => 'nullable|numeric',
            'cena' => 'nullable|numeric',
            'traslado_local' => 'nullable|numeric',
            'traslado_externo' => 'nullable|numeric',
            'comision_bancaria' => 'nullable|numeric',

            'employee_id' => 'required|string|exists:employees,id|max:50',
            'project_id' => 'required|string|exists:projects,id|max:80',

            'ajuste_retiro' => 'nullable|boolean',
            'monto_extra_ecore' => 'required_with:ajuste_retiro|nullable|numeric|min:0',
            'campo_descontar' => 'required_with:ajuste_retiro|nullable|in:desayuno,comida,cena,traslado_local,traslado_externo,comision_bancaria',
            'fecha_descontar' => 'required_with:ajuste_retiro|nullable|date',
        ];
    }

    public function messages(): array
    {
        return [
            // Fecha de corte.
            'fecha_dispersion_dia.required' => 'La fecha de corte es obligatoria.',
            'fecha_dispersion_dia.date' => 'La fecha de corte debe ser una fecha válida.',

            // Campos numéricos.
            'desayuno.numeric' => 'El campo desayuno debe ser un número válido.',
            'comida.numeric' => 'El campo comida debe ser un número válido.',
            'cena.numeric' => 'El campo cena debe ser un número válido.',
            'traslado_local.numeric' => 'El campo traslado local debe ser un número válido.',
            'traslado_externo.numeric' => 'El campo traslado externo debe ser un número válido.',
            'comision_bancaria.numeric' => 'El campo comisión bancaria debe ser un número válido.',

            // Relaciones.
            'employee_id.required' => 'El RFC del empleado es obligatorio.',
            'employee_id.string' => 'El RFC del empleado debe ser una cadena de texto.',
            'employee_id.exists' => 'El RFC del empleado no existe en la base de datos.',
            'employee_id.max' => 'El RFC del empleado no puede exceder los 50 caracteres.',

            'project_id.required' => 'El identificador del proyecto es obligatorio.',
            'project_id.string' => 'El identificador del proyecto debe ser una cadena de texto.',
            'project_id.exists' => 'El proyecto seleccionado no existe en la base de datos.',
            'project_id.max' => 'El identificador del proyecto no puede exceder los 80 caracteres.',

            // Ajuste por retiro.
            'ajuste_retiro.boolean' => 'El campo ajuste por retiro debe ser verdadero o falso.',

            'monto_extra_ecore.required_with' => 'El monto del ajuste es obligatorio cuando se especifica un ajuste por retiro.',
            'monto_extra_ecore.numeric' => 'El monto del ajuste debe ser un número válido.',
            'monto_extra_ecore.min' => 'El monto del ajuste no puede ser negativo.',

            'campo_descontar.required_with' => 'El campo a descontar es obligatorio cuando se especifica un ajuste por retiro.',
            'campo_descontar.in' => 'El campo a descontar debe ser uno de los campos válidos del reporte (desayuno, comida, cena, traslado_local, traslado_externo o comision_bancaria).',

            'fecha_descontar.required_with' => 'La fecha a descontar es obligatoria cuando se especifica un ajuste por retiro.',
            'fecha_descontar.date' => 'La fecha a descontar debe ser una fecha válida.',
        ];
    }
}
