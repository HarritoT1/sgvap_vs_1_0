<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TagDispersion>
 */
class TagDispersionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = \App\Models\TagDispersion::class;
    
    public function definition(): array
    {
        $base_imponible = $this->faker->randomFloat(6, 100, 5000); // Monto base sin IVA
        $iva_caseta = round($base_imponible * 0.16, 6); // IVA del 16%
        $importe_total = round($base_imponible + $iva_caseta, 6);

        return [
            'fecha_dispersion' => $this->faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
            'project_id' => \App\Models\Project::query()->inRandomOrder()->value('id'),
            'vehicle_id' => \App\Models\Vehicle::query()->inRandomOrder()->value('id'),
            'nombre_caseta' => $this->faker->city() . ' - ' . $this->faker->city(), // Ej: "Puebla - CDMX"
            'base_imponible' => $base_imponible,
            'iva_caseta' => $iva_caseta,
            'importe_total' => $importe_total,
        ];
    }
}
