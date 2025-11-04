<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
            'monto_est_vtc_alimentos' => $this->emptyToNull($this->input('monto_est_vtc_alimentos')),
            'monto_est_vtc_tras_local' => $this->emptyToNull($this->input('monto_est_vtc_tras_local')),
            'monto_est_vtc_tras_externo' => $this->emptyToNull($this->input('monto_est_vtc_tras_externo')),
            'monto_est_vtc_com_bancaria' => $this->emptyToNull($this->input('monto_est_vtc_com_bancaria')),
            'monto_est_vtc_gasolina' => $this->emptyToNull($this->input('monto_est_vtc_gasolina')),
            'monto_est_vtc_caseta' => $this->emptyToNull($this->input('monto_est_vtc_caseta')),
            'monto_est_vtc_hospedaje' => $this->emptyToNull($this->input('monto_est_vtc_hospedaje')),
            'notas' => $this->emptyToNull($this->input('notas')),

            'id' => trim($this->input('id')),
            'customer_id' => trim($this->input('customer_id')),
            'nombre' => trim($this->input('nombre')),
            'sitio' => trim($this->input('sitio')),
            'estimado_tiempo' => trim($this->input('estimado_tiempo')),
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
            'id' => 'required|string|max:80|unique:projects,id,'.$this->input("id_project"),
            'customer_id' => 'string|exists:customers,id|max:50',
            'nombre' => 'required|string|max:300',
            'sitio' => 'required|string|max:300',
            'monto_cobrar' => 'required|numeric|min:0',
            'monto_est_vtc_alimentos' => 'nullable|numeric|min:0',
            'monto_est_vtc_tras_local' => 'nullable|numeric|min:0',
            'monto_est_vtc_tras_externo' => 'nullable|numeric|min:0',
            'monto_est_vtc_com_bancaria' => 'nullable|numeric|min:0',
            'monto_est_vtc_gasolina' => 'nullable|numeric|min:0',
            'monto_est_vtc_caseta' => 'nullable|numeric|min:0',
            'monto_est_vtc_hospedaje' => 'nullable|numeric|min:0',
            'estimado_viaticos' => 'required|numeric|min:0',
            'estimado_tiempo' => 'required|string|max:150',
            'fecha_limite' => 'required|date', /* |after:yesterday */
            'notas' => 'nullable|string|max:300',
            'status' => 'required|in:activo,concluido'
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'El campo ID del proyecto es obligatorio.',
            'id.unique' => 'El ID del proyecto ya existe.',
            'id.max' => 'El ID no debe exceder los 80 caracteres.',

            'customer_id.exists' => 'El cliente seleccionado no existe.',
            'customer_id.max' => 'El ID del cliente no debe exceder los 50 caracteres.',

            'nombre.required' => 'El nombre del proyecto es obligatorio.',
            'nombre.max' => 'El nombre no debe exceder los 300 caracteres.',

            'sitio.required' => 'El sitio es obligatorio.',
            'sitio.max' => 'El sitio no debe exceder los 300 caracteres.',

            'monto_cobrar.required' => 'El monto a cobrar es obligatorio.',
            'monto_cobrar.numeric' => 'El monto a cobrar debe ser un número válido.',
            'monto_cobrar.min' => 'El monto a cobrar no puede ser negativo.',

            'monto_est_vtc_alimentos.numeric' => 'El monto estimado para viáticos de alimentos debe ser un número válido.',
            'monto_est_vtc_tras_local.numeric' => 'El monto estimado para viáticos de transporte local debe ser un número válido.',
            'monto_est_vtc_tras_externo.numeric' => 'El monto estimado para viáticos de transporte externo debe ser un número válido.',
            'monto_est_vtc_com_bancaria.numeric' => 'El monto estimado para viáticos de comisión bancaria debe ser un número válido.',
            'monto_est_vtc_gasolina.numeric' => 'El monto estimado para viáticos de gasolina debe ser un número válido.',
            'monto_est_vtc_caseta.numeric' => 'El monto estimado para viáticos de caseta debe ser un número válido.',
            'monto_est_vtc_hospedaje.numeric' => 'El monto estimado para viáticos de hospedaje debe ser un número válido.',

            'monto_est_vtc_alimentos.min' => 'El monto estimado para viáticos de alimentos no puede ser negativo.',
            'monto_est_vtc_tras_local.min' => 'El monto estimado para viáticos de transporte local no puede ser negativo.',
            'monto_est_vtc_tras_externo.min' => 'El monto estimado para viáticos de transporte externo no puede ser negativo.',
            'monto_est_vtc_com_bancaria.min' => 'El monto estimado para viáticos de comisión bancaria no puede ser negativo.',
            'monto_est_vtc_gasolina.min' => 'El monto estimado para viáticos de gasolina no puede ser negativo.',
            'monto_est_vtc_caseta.min' => 'El monto estimado para viáticos de caseta no puede ser negativo.',
            'monto_est_vtc_hospedaje.min' => 'El monto estimado para viáticos de hospedaje no puede ser negativo.',

            'estimado_viaticos.required' => 'El estimado de viáticos es obligatorio.',
            'estimado_viaticos.numeric' => 'El estimado de viáticos debe ser un número válido.',
            'estimado_viaticos.min' => 'El estimado de viáticos no puede ser negativo.',

            'estimado_tiempo.required' => 'El estimado de tiempo es obligatorio.',
            'estimado_tiempo.max' => 'El estimado de tiempo no debe exceder los 150 caracteres.',

            'fecha_limite.required' => 'La fecha límite es obligatoria.',
            'fecha_limite.date' => 'La fecha límite debe ser una fecha válida.',
            'fecha_limite.after' => 'La fecha límite debe ser posterior a ayer.',

            'notas.max' => 'Las notas no deben exceder los 300 caracteres.',

            'status.required' => 'El estado del proyecto es obligatorio.',
            'status.in' => 'El estado del proyecto debe ser "activo" o "concluido".',
        ];
    }
}
