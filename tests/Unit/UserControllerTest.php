<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Factories\UserFactory;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;


    public function test_rota_screen_can_be_rendered() : void
    {
        $response = $this->get('/Usuario/alteraruser');

        $response->assertStatus(302);
    }

    public function test_rotaADM_screen_can_be_rendered() : void
    {
        $response = $this->get('/Usuario/alteraruserADM');

        $response->assertStatus(302);
    }
    public function testEdit()
    {
        // Crie um usuário falso e logue-o
        $user = UserFactory::new()->create();
        $this->actingAs($user);

        // Simule a chamada para UserController::edit
        $response = $this->get(route('usuario.edit', ['id' => $user->id]));

        // Verifique se a resposta tem status 200 (OK)
        $response->assertStatus(200);
    }

    public function testUpdate()
    {
        // Crie um usuário falso e logue-o
        $user = UserFactory::new()->create();
        $this->actingAs($user);

        // Simule a chamada para UserController::update
        $response = $this->put(route('usuario.update', ['ID' => $user->id]), [
            'nome' => 'Novo Nome',
            'password' => 'nova_senha',
        ]);

        // Verifique se a resposta redireciona para a rota correta
        $response->assertRedirect(route('usuario.telainicial'));
    }

    public function testEditADM()
    {
        // Crie um usuário falso no banco de dados
        $user = UserFactory::new()->create();

        // Simule a chamada para UserController::editADM
        $response = $this->get(route('usuario.editADM', ['ID' => $user->id]));

        // Verifique se a resposta tem status 200 (OK)
        $response->assertStatus(200);
    }


    public function testUpdateADM()
    {
        // Crie um usuário falso no banco de dados usando a classe UserFactory
        $user = UserFactory::new()->create();
        
        // Simule a chamada para UserController::updateADM
        $response = $this->put(route('usuario.updateADM', ['ID' => $user->id]), [
            'nome' => 'Novo Nome',
            'password' => 'nova_senha',
        ]);
        
        // Verifique se a resposta redireciona para a rota correta
        $response->assertRedirect(route('usuario.telainicial'));
    }
}
