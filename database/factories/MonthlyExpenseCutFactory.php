<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employee;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MonthlyExpenseCut>
 */
class MonthlyExpenseCutFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = \App\Models\MonthlyExpenseCut::class;

    public function definition(): array
    {
        return [
            'mes' => $this->faker->numberBetween(1, 12),
            'anio' => $this->faker->unique()->numberBetween(2000, now()->year + 20),
            'total_alimentos_mes' => $this->faker->optional()->randomFloat(2, 0, 50000),
            'total_traslado_local_mes' => $this->faker->optional()->randomFloat(2, 0, 20000),
            'total_traslado_externo_mes' => $this->faker->optional()->randomFloat(2, 0, 20000),
            'total_comision_bancaria_mes' => $this->faker->optional()->randomFloat(2, 0, 1000),
            'total_comision_sivale_mes' => $this->faker->optional()->randomFloat(2, 0, 1000),
            'total_iva_mes' => $this->faker->optional()->randomFloat(2, 0, 10000),
            'employee_id' => Employee::inRandomOrder()->value('id'), // o null si no hay empleados.
        ];
    }
}
