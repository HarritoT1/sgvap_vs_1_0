<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Project;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LodgingDispersion>
 */
class LodgingDispersionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\LodgingDispersion::class;

    public function definition(): array
    {
        // Número de noches y costo por noche simulados.
        $numero_noches = $this->faker->numberBetween(1, 7);
        $costo_x_noche = $this->faker->randomFloat(2, 800, 5000); // costo por noche entre $800 y $5000.
        $numero_personas = $this->faker->numberBetween(1, 5);

        // Calcular el importe total (costo * noches * personas)
        $importe_total = (float) round($costo_x_noche * $numero_noches);

        // Calcular base imponible e IVA (asumiendo IVA del 16%)
        $base_imponible = $importe_total / 1.16;
        $iva_hospedaje = $importe_total - $base_imponible;

        return [
            'fecha_dispersion' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'project_id' => Project::inRandomOrder()->first()?->id,
            'rfc_hospedaje' => strtoupper($this->faker->bothify('????######A##')),
            'razon_social' => $this->faker->company(),
            'numero_noches' => $numero_noches,
            'costo_x_noche' => $costo_x_noche,
            'numero_personas' => $numero_personas,
            'base_imponible' => round($base_imponible, 6),
            'iva_hospedaje' => round($iva_hospedaje, 6),
            'importe_total' => round($importe_total, 6),
        ];
    }
}
