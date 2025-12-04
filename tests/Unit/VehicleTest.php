<?php

namespace Tests\Unit;

use Tests\TestCase; // ESTA es la clase que carga Laravel
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;

class VehicleTest extends TestCase
{
    use DatabaseTransactions;

    public function test_creacion_de_vehiculo()
    {
        //dd(config('database.connections.mysql.database'));

        $user = User::factory()->create();

        $this->actingAs($user); // Simula que el usuario está autenticado.

        $data = [
            'id' => "ASP-NET-ZXZ",
            'nombre_modelo' => "MAZDA 3",
            'marca' => "MAZDA",
            'anio' => 2020,
            'color' => "ROJO",
            'ruta_foto_1' => null,
            'km_actual' => 15000,
            'caracteristicas' => [
                "Tapones llantas",
                "Cristales puertas",
                "Llanta refaccion",
                "Limpiadores",
                "Parabrisas trasero",
                "Medallon",
                "Placa delantera",
                "Faros",
                "Tapetes",
            ],
            'obs_gral' => "Vehículo en buen estado.",
        ];

        $response = $this->from('/gv_registro_vehiculos')->post('/vehicle_create', $data);

        /* Aquí cuidado: no puedes mezclar assertRedirect con assertSee o assertView
           después de que ya hubo redirección. assertSee y assertView requieren
           que la respuesta sea una vista, no una redirección. 
        */

        $response->assertStatus(302)
            ->assertRedirect('/gv_consulta_act?id=' . $data['id']) // Valida que la ruta a la que redirige es la correcta.
            ->assertSessionHas('success', 'Vehículo registrado exitosamente.')
            ->assertSessionHasNoErrors(); // Asegura que no hay errores en la sesión.

        // Si quieres validar la vista redirigida, tienes que seguir la redirección:
        $follow = $this->get('/gv_consulta_act?id=' . $data['id']);

        $follow->assertViewIs('Gestion_vehiculos.gv_consulta_act')
            ->assertViewHas('vehicle', function ($vehicle) use ($data) {
                return $vehicle->id === $data['id'];
            })
            ->assertSee('Detalles del vehículo con la placa: ' . $data['id']);

        $this->assertDatabaseHas('vehicles', [
            'id' => $data['id'],
            'nombre_modelo' => $data['nombre_modelo'],
            'marca' => $data['marca'],
            'anio' => $data['anio'],
            'color' => $data['color'],
            'ruta_foto_1' => $data['ruta_foto_1'],
            'km_actual' => $data['km_actual'],
            'caracteristicas' => implode(',', $data['caracteristicas']),
            'obs_gral' => $data['obs_gral'],
        ]);
    }
}
