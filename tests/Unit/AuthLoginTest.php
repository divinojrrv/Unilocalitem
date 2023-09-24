<?php


namespace App\Tests\Unit\Controllers;

use App\Http\Controllers\LoginController;
use App\Models\User;
use Auth;
use Mockery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthLoginTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;


    public function test_realizar_login_com_cpf_invalido()
{
    // Crie um usuário no banco de dados.
    $user = User::factory()->create();

    // Envie uma solicitação de login com um CPF inválido.
    $response = $this->post('/Home', [
        'cpf' => '12345678901',
        'password' => 'password',
    ]);

    // Verifique se a resposta da solicitação é um redirecionamento para a rota /login.
    $response->assertRedirect('/');
}




}
