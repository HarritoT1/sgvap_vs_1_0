<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Customer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = \App\Models\Project::class;

    public function definition(): array
    {
        return [
            'id' => strtoupper($this->faker->unique()->bothify('PRJ-####-???')),
            'customer_id' => Customer::query()->inRandomOrder()->value('id'), // Toma el id de un cliente existente.
            'nombre' => $this->faker->unique()->sentence(3),
            'sitio' => $this->faker->city(),
            'monto_cobrar' => $this->faker->randomFloat(2, 10000, 500000),
            'monto_est_vtc_alimentos' => $this->faker->randomFloat(2, 500, 5000),
            'monto_est_vtc_tras_local' => $this->faker->randomFloat(2, 500, 5000),
            'monto_est_vtc_tras_externo' => $this->faker->randomFloat(2, 500, 5000),
            'monto_est_vtc_com_bancaria' => $this->faker->randomFloat(2, 100, 1000),
            'monto_est_vtc_gasolina' => $this->faker->randomFloat(2, 500, 5000),
            'monto_est_vtc_caseta' => $this->faker->randomFloat(2, 200, 2000),
            'monto_est_vtc_hospedaje' => $this->faker->randomFloat(2, 500, 7000),
            'estimado_viaticos' => $this->faker->randomFloat(2, 1000, 15000),
            'estimado_tiempo' => $this->faker->numberBetween(1, 60) . ' días',
            'fecha_limite' => $this->faker->dateTimeBetween('now', '+6 months'),
            'notas' => $this->faker->optional()->sentence(10),
            'status' => $this->faker->randomElement(['activo', 'concluido']),
        ];
    }
}
