<?php

namespace Tests\Unit;

use Tests\TestCase; // ESTA es la clase que carga Laravel
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;

class EmployeeTest extends TestCase
{
    use DatabaseTransactions;

    public function test_creacion_de_empleado()
    {
        //dd(config('database.connections.mysql.database'));

        $user = User::factory()->create();

        $this->actingAs($user); // Simula que el usuario está autenticado.

        $data = [
            'id' => "RPJ45CRRRA3L6",
            'puesto' => "Ingeniero en Telecomunicaciones",
            'nombre' => "Miguel Angel Mancera Hernandez",
            'modo' => "interno",
        ];

        $response = $this->from('/ge_nuevo')->post('/employee_create', $data);

        /* Aquí cuidado: no puedes mezclar assertRedirect con assertSee o assertView
           después de que ya hubo redirección. assertSee y assertView requieren
           que la respuesta sea una vista, no una redirección. 
        */ 

        $response->assertStatus(302)
            ->assertRedirect('/ge_consulta_act?id=' . $data['id']) // Valida que la ruta a la que redirige es la correcta.
            ->assertSessionHas('success', 'Empleado creado exitosamente ;).')
            ->assertSessionHasNoErrors(); // Asegura que no hay errores en la sesión.

        // Si quieres validar la vista redirigida, tienes que seguir la redirección:
        $follow = $this->get('/ge_consulta_act?id=' . $data['id']);

        $follow->assertViewIs('Gestion_empleados.ge_consulta_act')
            ->assertViewHas('employee', function ($employee) use ($data) {
                return $employee->id === $data['id'];
            })
            ->assertSee('Datos del empleado con el RFC: ' . $data['id']);

        $this->assertDatabaseHas('employees', [
            'id' => $data['id'],
            'puesto' => $data['puesto'],
            'nombre' => $data['nombre'],
            'modo' => $data['modo'],
        ]);
    }
}
