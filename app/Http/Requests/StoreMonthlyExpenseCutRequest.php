<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMonthlyExpenseCutRequest extends FormRequest
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
            "total_comision_sivale_mes" => $this->emptyToNull($this->input('total_comision_sivale_mes')) ?? 0,
            "total_iva_mes" => $this->emptyToNull($this->input('total_iva_mes')) ?? 0,
        ]);
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
            'employee_id' => 'required|string|exists:employees,id|max:50',
            'mes' => 'required|integer|min:1|max:12',
            'anio' => 'required|integer|min:2000|max:2150',
            'total_alimentos_mes' => 'required|numeric',
            'total_traslado_local_mes' => 'required|numeric',
            'total_traslado_externo_mes' => 'required|numeric',
            'total_comision_bancaria_mes' => 'required|numeric',
            'total_comision_sivale_mes' => 'required|numeric',
            'total_iva_mes' => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'employee_id.required' => 'El RFC del empleado es obligatorio.',    
            'employee_id.string' => 'El RFC del empleado debe ser una cadena de texto.',
            'employee_id.exists' => 'El RFC del empleado no existe en la base de datos.',
            'employee_id.max' => 'El RFC del empleado no puede exceder los 50 caracteres.',

            'mes.required' => 'El mes es obligatorio.',
            'mes.integer' => 'Debes mandar un número de mes válido.',
            'mes.min' => 'El mes debe ser mayor o igual a 1.',
            'mes.max' => 'El mes debe ser menor o igual a 12.',

            'anio.required' => 'El año es obligatorio.',
            'anio.integer' => 'Debes mandar un número de año válido.',
            'anio.min' => 'El año debe ser mayor o igual a 2000.',
            'anio.max' => 'El año debe ser menor o igual a 2150.',

            'total_alimentos_mes.required' => 'El total de alimentos es obligatorio.',
            'total_alimentos_mes.numeric' => 'El total de alimentos debe ser un número válido.',

            'total_traslado_local_mes.required' => 'El total de traslado local es obligatorio.',
            'total_traslado_local_mes.numeric' => 'El total de traslado local debe ser un número válido.',

            'total_traslado_externo_mes.required' => 'El total de traslado externo es obligatorio.',
            'total_traslado_externo_mes.numeric' => 'El total de traslado externo debe ser un número válido.',      

            'total_comision_bancaria_mes.required' => 'El total de comisión bancaria es obligatorio.',
            'total_comision_bancaria_mes.numeric' => 'El total de comisión bancaria debe ser un número válido.',

            'total_comision_sivale_mes.required' => 'El total de comisión sivale es obligatorio.',
            'total_comision_sivale_mes.numeric' => 'El total de comisión sivale debe ser un número válido.',

            'total_iva_mes.required' => 'El total de IVA es obligatorio.',
            'total_iva_mes.numeric' => 'El total de IVA debe ser un número válido.',
        ];
    }
}
