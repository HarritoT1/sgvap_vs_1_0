<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employee;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ExtraEcoreDebt>
 */
class ExtraEcoreDebtFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $campos = ['desayuno', 'comida', 'cena', 'traslado_local', 'traslado_externo', 'comision_bancaria'];
        $status = ['pendiente', 'descontado'];

        return [
            'monto_extra_ecore' => $this->faker->randomFloat(4, 10, 2000), // 10 a 2000 con 4 decimales.
            'campo_descontar' => $this->faker->randomElement($campos),
            'fecha_descontar' => $this->faker->unique()->dateTimeBetween('now', '+2 month'),
            'status' => $this->faker->randomElement($status),
            'employee_id' => Employee::query()->inRandomOrder()->value('id'),
        ];
    }
}
