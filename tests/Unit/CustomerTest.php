<?php

namespace Tests\Unit;

use Tests\TestCase; // ESTA es la clase que carga Laravel
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;

class CustomerTest extends TestCase
{
    use DatabaseTransactions;

    public function testCustomerCreation()
    {
        //dd(config('database.connections.mysql.database'));

        $user = User::factory()->create();

        $this->actingAs($user); // Simula que el usuario está autenticado.

        $data = [
            'id' => "CATH031212GHT332",
            'razon_social' => "CHL Industrial S.A. de C.V.",
            'ubicacion' => "Calle 5 de Febrero No. 123, Col. Centro, C.P. 06000, Ciudad de México, México"
        ];

        $response = $this->from('/gc_nuevo')->post('/customer_create', $data);

        // Aquí cuidado: no puedes mezclar assertRedirect con assertSee o assertView
        // después de que ya hubo redirección. assertSee y assertView requieren
        // que la respuesta sea una vista, no una redirección.

        $response->assertStatus(302)
            ->assertRedirect('/gc_consulta_act?id=' . $data['id']) // Valida que la ruta a la que redirige es la correcta.
            ->assertSessionHas('success', 'Cliente creado exitosamente ;).');

        // Si quieres validar la vista redirigida, tienes que seguir la redirección:
        $follow = $this->get('/gc_consulta_act?id=' . $data['id']);

        $follow->assertViewIs('Gestion_clientes.gc_consulta_act')
            ->assertViewHas('customer', function ($customer) use ($data) {
                return $customer->id === $data['id'];
            })
            ->assertSee('Datos del cliente con el RFC: ' . $data['id']);

        $this->assertDatabaseHas('customers', [
            'id' => $data['id'],
            'razon_social' => $data['razon_social'],
            'ubicacion' => $data['ubicacion'],
        ]);
    }
}
