<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VehicleLoan;
use App\Models\Vehicle;

class VehicleLoanSeeder extends Seeder
{
    public function run()
    {
        $vehiculosUsados = collect();

        for ($i = 0; $i < 5; $i++) {

            // Buscar vehículos funcionales y no prestados que NO estén ya en la colección.
            $vehicle = Vehicle::where('status', 'funcional')
                ->where('is_on_loan', false)
                ->whereNotIn('id', $vehiculosUsados)
                ->inRandomOrder()
                ->first();

            if (! $vehicle) {
                // No hay vehículos disponibles.
                break;
            }

            // Crear el préstamo con el vehicle_id fijo.
            $newVehicleLoan = VehicleLoan::factory()->create([
                'vehicle_id' => $vehicle->id,
                'km_salida'  => $vehicle->km_actual,
            ]);

            // Marcar este vehículo como usado.
            $vehiculosUsados->push($vehicle->id);

            // (Opcional) marcarlo como prestado en BD.
            if($newVehicleLoan->status == 'no_entregado') $vehicle->update(['is_on_loan' => true]);
            else $vehicle->update(['is_on_loan' => false, 'km_actual' => $newVehicleLoan->km_retorno]); 
        }
    }
}
