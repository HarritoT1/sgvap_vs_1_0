<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Project;
use App\Models\Vehicle;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GasolineDispersion>
 */
class GasolineDispersionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = \App\Models\GasolineDispersion::class;

    public function definition(): array
    {
        // Aseguramos que los cálculos de monto, base e IVA sean coherentes.
        $costo_lt = $this->faker->randomFloat(4, 20, 35); // Precio por litro entre 20 y 35 MXN.
        $cant_litros = $this->faker->randomFloat(4, 10, 60); // Litros cargados.

        //Monto dispersado tiene que ser un flotante pero entero, es decir el banco acepta solo depositos sin centavos.
        $monto_dispersado = (float) round($costo_lt * $cant_litros);

        // Supongamos IVA 16%:
        $base_imponible = $monto_dispersado / 1.16;
        $iva_acumulado = $monto_dispersado - $base_imponible;
        $importe_total = $monto_dispersado;

        return [
            'fecha_dispersion' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'project_id' => Project::query()->inRandomOrder()->value('id'),
            'vehicle_id' => Vehicle::query()->inRandomOrder()->value('id'),
            'costo_lt' => $costo_lt,
            'cant_litros' => $cant_litros,
            'monto_dispersado' => round($monto_dispersado, 6),
            'base_imponible' => round($base_imponible, 6),
            'iva_acumulado' => round($iva_acumulado, 6),
            'importe_total' => round($importe_total, 6),
        ];
    }
}
