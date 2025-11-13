<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = \App\Models\Vehicle::class;

    public function definition(): array
    {
        $marcasModelos = [
            'Toyota' => ['Corolla', 'Hilux', 'RAV4', 'Yaris'],
            'Nissan' => ['Versa', 'Sentra', 'Frontier', 'X-Trail'],
            'Chevrolet' => ['Aveo', 'Tracker', 'Spark', 'Onix'],
            'Volkswagen' => ['Jetta', 'Polo', 'Tiguan', 'Vento'],
            'Ford' => ['Focus', 'Ranger', 'Escape', 'Fiesta'],
        ];

        $marca = $this->faker->randomElement(array_keys($marcasModelos));
        $modelo = $this->faker->randomElement($marcasModelos[$marca]);

        return [
            'id' => strtoupper($this->faker->unique()->bothify('??-##-###')), // Placa: formato tipo AB-12-345.
            'nombre_modelo' => $modelo,
            'marca' => $marca,
            'anio' => $this->faker->numberBetween(2000, date('Y')),
            'color' => $this->faker->safeColorName(),
            'ruta_foto_1' => $this->faker->optional()->imageUrl(640, 480, 'car', true, 'auto'),
            'km_actual' => $this->faker->numberBetween(5000, 250000),
            'obs_gral' => $this->faker->optional()->sentence(10),
            'status' => $this->faker->randomElement(['funcional', 'mantenimiento']),
            'is_on_loan' => $this->faker->boolean(15), // 15% de probabilidad de estar en préstamo.
            'caracteristicas' => implode(',', $this->faker->randomElements([
                'Retrovisor izquierdo',
                'Retrovisor derecho',
                'Tapon gasolina',
                'Tapones llantas',
                'Cristales puertas',
                'Llanta refaccion',
                'Limpiadores',
                'Parabrisas frontal',
                'Parabrisas trasero',
                'Medallon',
                'Molduras',
                'Calaveras',
                'Parrilla',
                'Placa delantera',
                'Placa trasera',
                'Faros',
                'Retrovisor',
                'Tapetes',
                'Claxon',
                'Estereo',
                'Poliza de seguro',
                'Tarjeta de circulacion',
            ], $this->faker->numberBetween(5, 12))), // selecciona entre 5 y 12 características al azar.
        ];
    }
}
