<?php

namespace Tests\Unit;

use Tests\TestCase; // ESTA es la clase que carga Laravel
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;
use App\Models\Project;
use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;

class GDMTest extends TestCase
{
    use DatabaseTransactions;

    public function test_creacion_de_dispersion_gasolina()
    {
        //dd(config('database.connections.mysql.database'));

        $user = User::factory()->create();

        $this->actingAs($user); // Simula que el usuario está autenticado.

        $project = Project::all()->random();

        $vehicle = Vehicle::all()->random();

        $nextId = DB::select("SHOW TABLE STATUS LIKE 'gasoline_dispersions'")[0]->Auto_increment;

        $data = [
            'fecha_dispersion' => '2025-12-15',
            'project_id' => $project->id,
            'vehicle_id' => $vehicle->id,
            'costo_lt' => 25.50,
            'cant_litros' => 40,
            'monto_dispersado' => 1020.00, // 25.50 * 40.
            'base_imponible' => 879.310, // 1020 / 1.16.
            'iva_acumulado' => 140.690, // 1020 - 879.310.
            'importe_total' => 1020.00,
        ];

        $response = $this->from('/gdm_gasolina_alta_dispersion')->post('/gasoline_create', $data);

        /* Aquí cuidado: no puedes mezclar assertRedirect con assertSee o assertView
           después de que ya hubo redirección. assertSee y assertView requieren
           que la respuesta sea una vista, no una redirección. 
        */ 

        $response->assertStatus(302)
            ->assertRedirect('/gdm_gasolina_disp_consulta_act/' . $nextId) // Valida que la ruta a la que redirige es la correcta.
            ->assertSessionHas('success', 'Dispersión de gasolina registrada exitosamente ;).')
            ->assertSessionHasNoErrors(); // Asegura que no hay errores en la sesión.

        // Si quieres validar la vista redirigida, tienes que seguir la redirección:
        $follow = $this->get('/gdm_gasolina_disp_consulta_act/' . $nextId);

        $follow->assertViewIs('Gestion_dispersiones_monetarias.gdm_gasolina_disp_consulta_act')
            ->assertViewHas('dispersion', function ($dispersion) use ($nextId) {
                return $dispersion->id === $nextId;
            })
            ->assertSee('Detalles de la dispersión de gasolina:');

        $this->assertDatabaseHas('gasoline_dispersions', [
            'id' =>  $nextId,
            'fecha_dispersion' => $data['fecha_dispersion'],
            'project_id' => $data['project_id'],
            'vehicle_id' => $data['vehicle_id'],
            'costo_lt' => $data['costo_lt'],
            'cant_litros' => $data['cant_litros'],
            'monto_dispersado' => $data['monto_dispersado'],
            'base_imponible' => $data['base_imponible'],
            'iva_acumulado' => $data['iva_acumulado'],
            'importe_total' => $data['importe_total'],
        ]);
    }
}
