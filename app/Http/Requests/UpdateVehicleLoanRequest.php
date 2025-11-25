<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVehicleLoanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
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
            'is_on_loan' => strtoupper(trim($this->input('is_on_loan'))),
            'caracteristicas' => trim(implode(',', $this->input('caracteristicas', []))),
            'proveedor' => trim($this->input('proveedor')),
            'prestamo_obs_gral' => $this->emptyToNull($this->input('obs_gral')),
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
            'vehicle_status' => 'required|in:funcional,mantenimiento',
            'is_on_loan' => 'required|in:SI,NO',
            'caracteristicas' => 'required|string',
            'proveedor'   => 'required|string|max:100',
            'prestamo_status' => 'required|in:entregado,no_entregado',
            'fecha_devolucion' => 'required|date|after_or_equal:' . $this->input('fecha_prestamo'),
            'km_retorno' => 'required|integer|min:0|gte:'. $this->input('km_salida'),

            'ruta_evidencia_1' => 'nullable|mimes:png,jpeg,jpg,webp,gif|max:5120',
            'ruta_evidencia_2' => 'nullable|mimes:png,jpeg,jpg,webp,gif|max:5120',
            'ruta_evidencia_3' => 'nullable|mimes:png,jpeg,jpg,webp,gif|max:5120',
            'ruta_evidencia_4' => 'nullable|mimes:png,jpeg,jpg,webp,gif|max:5120',
            'ruta_evidencia_5' => 'nullable|mimes:png,jpeg,jpg,webp,gif|max:5120',

            'prestamo_obs_gral' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'vehicle_status.required' => 'Debes seleccionar el estado actual del vehículo.',
            'vehicle_status.in' => 'El estado del vehículo no es válido. Solo se permite funcional o mantenimiento.',

            'is_on_loan.required' => 'Debes indicar si el vehículo está prestado.',
            'is_on_loan.in' => 'El valor del campo “En prestamo” solo puede ser SI o NO.',

            'caracteristicas.required' => 'Debes seleccionar al menos una característica.',
            'caracteristicas.string' => 'Las características deben enviarse en un formato válido.',

            'proveedor.required' => 'El nombre del proveedor es obligatorio.',
            'proveedor.string' => 'El nombre del proveedor no es válido.',
            'proveedor.max' => 'El nombre del proveedor no debe exceder los 100 caracteres.',

            'prestamo_status.required' => 'Debes seleccionar el estado del préstamo.',
            'prestamo_status.in' => 'El estado del préstamo solo puede ser "PENDIENTE" o "CONCLUIDO".',

            'fecha_devolucion.required' => 'La fecha de devolución es obligatoria.',
            'fecha_devolucion.date' => 'La fecha de devolución no tiene un formato válido.',
            'fecha_devolucion.after_or_equal' => 'La fecha de devolución no puede ser anterior a la fecha de préstamo.',

            'km_retorno.required' => 'Debes capturar el kilometraje de retorno.',
            'km_retorno.integer' => 'El kilometraje de retorno debe ser un número entero.',
            'km_retorno.min' => 'El kilometraje de retorno no puede ser negativo.',
            'km_retorno.gte' => 'El kilometraje de retorno no puede ser menor al kilometraje previo al prestamo.',

            'ruta_evidencia_1.mimes' => 'El archivo de evidencia 1 debe ser una imagen válida.',
            'ruta_evidencia_1.max' => 'La evidencia 1 no debe superar los 5 MB.',

            'ruta_evidencia_2.mimes' => 'El archivo de evidencia 2 debe ser una imagen válida.',
            'ruta_evidencia_2.max' => 'La evidencia 2 no debe superar los 5 MB.',

            'ruta_evidencia_3.mimes' => 'El archivo de evidencia 3 debe ser una imagen válida.',
            'ruta_evidencia_3.max' => 'La evidencia 3 no debe superar los 5 MB.',

            'ruta_evidencia_4.mimes' => 'El archivo de evidencia 4 debe ser una imagen válida.',
            'ruta_evidencia_4.max' => 'La evidencia 4 no debe superar los 5 MB.',

            'ruta_evidencia_5.mimes' => 'El archivo de evidencia 5 debe ser una imagen válida.',
            'ruta_evidencia_5.max' => 'La evidencia 5 no debe superar los 5 MB.',

            'prestamo_obs_gral.string' => 'Las observaciones deben ser texto válido.',
            'prestamo_obs_gral.max' => 'Las observaciones no pueden superar los 500 caracteres.',
        ];
    }
}
