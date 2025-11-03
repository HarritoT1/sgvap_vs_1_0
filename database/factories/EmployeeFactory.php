<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => strtoupper($this->faker->bothify('???#########')), // RFC simulado, ej. ABC123456789
            'nombre' => $this->faker->unique()->name(),
            'puesto' => $this->faker->jobTitle(),
            'status' => $this->faker->randomElement(['activo', 'inactivo']),
            'modo' => $this->faker->randomElement(['interno', 'contratista']),
        ];
    }
}
