<?php

namespace Tests\Unit;

use Tests\TestCase; // ESTA es la clase que carga Laravel
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;
use App\Models\Project;
use App\Models\Customer;

class ProjectTest extends TestCase
{
    use DatabaseTransactions;

    public function test_creacion_de_proyecto()
    {
        //dd(config('database.connections.mysql.database'));

        $user = User::factory()->create();

        $this->actingAs($user); // Simula que el usuario está autenticado.

        $customer = Customer::all()->random();

        $data = [
            'id' => "RPJ-45DH-2025",
            'nombre' => "Instalación de cableado estructurado.",
            'sitio' => "ANTARA.",
            'customer_id' => $customer->id,
            'monto_cobrar' => 50000.00,
            'estimado_viaticos' => 15000.00,
            'estimado_tiempo' => '30 días',
            'fecha_limite' => '2025-12-31',
        ];

        $response = $this->from('/gp_nuevo')->post('/project_create', $data);

        /* Aquí cuidado: no puedes mezclar assertRedirect con assertSee o assertView
           después de que ya hubo redirección. assertSee y assertView requieren
           que la respuesta sea una vista, no una redirección. 
        */ 

        $response->assertStatus(302)
            ->assertRedirect('/gp_consulta_act?id=' . $data['id']) // Valida que la ruta a la que redirige es la correcta.
            ->assertSessionHas('success', 'Proyecto creado exitosamente ;).')
            ->assertSessionHasNoErrors(); // Asegura que no hay errores en la sesión.

        // Si quieres validar la vista redirigida, tienes que seguir la redirección:
        $follow = $this->get('/gp_consulta_act?id=' . $data['id']);

        $follow->assertViewIs('Gestion_proyectos.gp_consulta_act')
            ->assertViewHas('project', function ($project) use ($data) {
                return $project->id === $data['id'];
            })
            ->assertSee('Detalles del proyecto con el id: ' . $data['id']);

        $this->assertDatabaseHas('projects', [
            'id' => $data['id'],
            'nombre' => $data['nombre'],
            'sitio' => $data['sitio'],
            'customer_id' => $data['customer_id'],
            'monto_cobrar' => $data['monto_cobrar'],
            'estimado_viaticos' => $data['estimado_viaticos'],
            'estimado_tiempo' => $data['estimado_tiempo'],
            'fecha_limite' => $data['fecha_limite'],
        ]);
    }
}
