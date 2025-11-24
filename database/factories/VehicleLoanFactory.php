<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Project;
use App\Models\Vehicle;
use App\Models\Employee;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VehicleLoan>
 */
class VehicleLoanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = \App\Models\VehicleLoan::class;

    public function definition()
    {
        $fechaPrestamo = $this->faker->dateTimeBetween('-1 years', 'now');

        // Si quieres que a veces sea NULL.
        $setNull = $this->faker->boolean(30); // 30% en NULL, ajusta a tu gusto.

        $vehicle = Vehicle::where('status', 'funcional')->where('is_on_loan', false)->inRandomOrder()->first();

        return [
            'employee_id'       => Employee::query()->inRandomOrder()->where('status', 'activo')->value('id'),
            'proveedor'         => $this->faker->name(),
            'project_id'        => Project::query()->inRandomOrder()->where('status', 'activo')->value('id'),
            'vehicle_id'        => $vehicle?->id,

            'fecha_prestamo'   => $fechaPrestamo,
            'fecha_devolucion' => $setNull
                ? null
                : $this->faker->dateTimeBetween($fechaPrestamo, 'now'),

            'status'            => $setNull
                ? 'no_entregado'
                : 'entregado',

            'km_salida'         => $vehicle?->km_actual,
            'km_retorno'        => $setNull
                ? null: function (array $attrs) {
                return $this->faker->numberBetween(
                    $attrs['km_salida'],
                    $attrs['km_salida'] + 2000
                );
            },

            'ruta_evidencia_1'  => $setNull
                ? null : $this->faker->optional()->imageUrl(640, 480, 'car', true, 'auto'),
            'ruta_evidencia_2'  => $setNull
                ? null : $this->faker->optional()->imageUrl(640, 480, 'car', true, 'auto'),
            'ruta_evidencia_3'  => $setNull
                ? null : $this->faker->optional()->imageUrl(640, 480, 'car', true, 'auto'),
            'ruta_evidencia_4'  => $setNull
                ? null : $this->faker->optional()->imageUrl(640, 480, 'car', true, 'auto'),
            'ruta_evidencia_5'  => $setNull
                ? null : $this->faker->optional()->imageUrl(640, 480, 'car', true, 'auto'),

            'obs_gral'          => $setNull
                ? null : $this->faker->optional()->sentence(10),
        ];
    }
}
