<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AuthLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login()
    {
        $user = User::factory()->create(); // Crie um usuário fictício

        // Faça uma solicitação POST para o endpoint de login personalizado
        $response = $this->post('/Home', [
            'cpf' => $user->cpf,
            'password' => 'password', // Substitua 'password' pela senha correta do usuário
        ]);

        // Verifique se a resposta é bem-sucedida (200)
        $response->assertStatus(200);

        // Verifique se o usuário foi autenticado
        //$this->assertAuthenticatedAs($user);

        // Adicione um log para verificar o usuário autenticado
        //Log::info($user);

        // Verifique se o usuário foi redirecionado para a rota correta
        $response->assertRedirect(route('usuario.telainicial'));

        // Verifique se a variável de sessão 'user_id' está definida corretamente
        $this->assertEquals($user->id, session('user_id'));
    }
}
