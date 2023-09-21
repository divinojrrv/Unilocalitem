<?php

namespace App\Tests\Unit\Controllers;

use App\Http\Controllers\LoginController;
use App\Models\User;
use Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthLoginTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_realizar_login_com_sucesso()
    {
        // Crie um usuário no banco de dados.
        $user = User::factory()->create();
    
        // Envie uma solicitação de login com o CPF e a senha do usuário.
        $response = $this->post('/Home', [
            'cpf' => $user->cpf,
            'password' => 'password',
        ]);
    
        // Verifique se o usuário foi autenticado.
        $this->assertNotNull(Auth::user());
    
        // Verifique se a resposta da solicitação é um redirecionamento.
        $response->assertRedirect();
    }
    
    

    public function test_realizar_login_com_cpf_invalido()
{
    // Crie um usuário no banco de dados.
    $user = User::factory()->create();

    // Envie uma solicitação de login com um CPF inválido.
    $response = $this->post('/Home', [
        'cpf' => '12345678901',
        'password' => 'password',
    ]);

    // Verifique se o usuário não foi autenticado.
    $this->assertFalse(Auth::check());

    // Verifique se a resposta da solicitação é um redirecionamento para a rota /login.
    $response->assertRedirect('/');
}


    public function test_realizar_login_com_senha_invalida()
    {
        // Crie um usuário no banco de dados.
        $user = User::factory()->create();

        // Envie uma solicitação de login com a senha incorreta.
        $response = $this->post('/Home', [
            'cpf' => $user->cpf,
            'password' => 'wrong_password',
        ]);

        // Verifique se o usuário não foi autenticado.
        $this->assertFalse(Auth::check());

        // Verifique se o usuário foi redirecionado para a rota correta.
        $response->assertRedirect('/')->assertSessionHasErrors(['error']);
    }

    public function test_realizar_login_com_usuario_inativo()
    {
        // Crie um usuário inativo no banco de dados.
        $user = User::factory()->create(['status' => 0]);

        // Envie uma solicitação de login com o CPF e a senha do usuário.
        $response = $this->post('/Home', [
            'cpf' => $user->cpf,
            'password' => 'password',
        ]);

        // Verifique se o usuário não foi autenticado.
        $this->assertFalse(Auth::check());

        // Verifique se o usuário foi redirecionado para a rota correta.
        $response->assertRedirect('/')->assertSessionHasErrors(['error']);
    }
}
