<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = \App\Models\Customer::class;

    public function definition(): array
    {
        return [
            // RFC (id) como cadena única de 12 a 13 caracteres (simulando un RFC).
            'id' => strtoupper($this->faker->unique()->regexify('[A-Z]{3,4}[0-9]{6}[A-Z0-9]{3}')),
            
            // Razon social única.
            'razon_social' => $this->faker->unique()->company(),
            
            // Ubicación de la empresa.
            'ubicacion' => $this->faker->address(),
            
            // Status activo/inactivo.
            'status' => $this->faker->randomElement(['activo', 'inactivo']),
            
            // last_update se maneja automáticamente por la base de datos, puedes omitirlo.
            // 'last_update' => now(),
        ];
    }
}
