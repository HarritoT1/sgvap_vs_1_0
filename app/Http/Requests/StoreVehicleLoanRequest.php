<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleLoanRequest extends FormRequest
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
            'employee_id' => trim(explode('→', $this->input('employee_id'))[0]),
            'proveedor' => trim($this->input('proveedor')),
            'project_id' => trim(explode('→', $this->input('project_id'))[0]),
        ]);
    }

    public function rules(): array
    {
        return [
            'employee_id' => 'required|string|exists:employees,id|max:50',
            'proveedor'   => 'required|string|max:100',
            'project_id'  => 'required|string|exists:projects,id|max:80',
            'vehicle_id'  => 'required|string|exists:vehicles,id|max:20',
            'fecha_prestamo' => 'required|date|after:yesterday',
        ];
    }

    public function messages(): array
    {
        return [
            'employee_id.required' => 'El RFC del empleado es obligatorio.',
            'employee_id.exists'   => 'El RFC del empleado no existe en la base de datos.',
            'employee_id.max'      => 'El RFC del empleado es demasiado largo.',

            'proveedor.required'   => 'El proveedor es obligatorio.',
            'proveedor.string'     => 'El proveedor debe ser texto válido.',
            'proveedor.max'        => 'El proveedor no puede superar los 100 caracteres.',

            'project_id.required'  => 'El ID del proyecto es obligatorio.',
            'project_id.exists'    => 'El ID del proyecto no existe en la base de datos.',
            'project_id.max'       => 'El ID del proyecto es demasiado largo.',

            'vehicle_id.required'  => 'Debes seleccionar un vehículo.',
            'vehicle_id.exists'    => 'El vehículo seleccionado no existe en la base de datos.',
            'vehicle_id.max'       => 'El ID del vehículo es demasiado largo.',

            'fecha_prestamo.required' => 'La fecha de préstamo es obligatoria.',
            'fecha_prestamo.date'     => 'La fecha de préstamo no tiene un formato válido.',
            'fecha_prestamo.after' => 'La fecha de préstamo no puede ser anterior a hoy.',
        ];
    }
}
