<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employee;
use App\Models\Project;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DailyExpenseReport>
 */
class DailyExpenseReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = \App\Models\DailyExpenseReport::class;

    public function definition(): array
    {
        return [
            'fecha_dispersion_dia' => $this->faker->unique()->dateTimeBetween('-2 years', 'now'),
            'desayuno' => $this->faker->optional()->randomFloat(2, 10, 2500),
            'comida' => $this->faker->optional()->randomFloat(2, 10, 3000),
            'cena' => $this->faker->optional()->randomFloat(2, 10, 2000),
            'traslado_local' => $this->faker->optional()->randomFloat(2, 20, 5000),
            'traslado_externo' => $this->faker->optional()->randomFloat(2, 50, 15000),
            'comision_bancaria' => $this->faker->optional()->randomFloat(2, 5, 500),
            'employee_id' => Employee::query()->inRandomOrder()->value('id'),
            'project_id' => Project::query()->inRandomOrder()->value('id'),
        ];
    }
}
