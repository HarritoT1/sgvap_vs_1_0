<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Project;
use App\Models\Vehicle;

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
        $importe_total = (float) round($this->faker->randomFloat(2, 50, 500)); // Importe total entre 50 y 500 MXN.
        $base_imponible = $importe_total / 1.16; // Suponiendo IVA 16%
        $iva_caseta = $importe_total - $base_imponible;

        return [
            'fecha_dispersion' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'project_id' => Project::query()->inRandomOrder()->value('id'),
            'vehicle_id' => null,//Vehicle::query()->inRandomOrder()->value('id'),
            'nombre_caseta' => $this->faker->city() . ' - ' . $this->faker->city(), // Ej: "Puebla - CDMX"
            'base_imponible' => round($base_imponible, 6),
            'iva_caseta' => round($iva_caseta, 6),
            'importe_total' => round($importe_total, 6),
        ];
    }
}
