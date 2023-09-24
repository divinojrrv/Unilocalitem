<?php

namespace App\Tests\Unit\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use App\Http\Controllers\LoginController;
use App\Models\User;
use App\Repositories\PublicacoesRepository; // Importe a classe PublicacoesRepository
use Illuminate\Http\RedirectResponse;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase; // Para usar um banco de dados em memória
    protected $environment = 'testing';

    protected function setUp(): void
    {
        parent::setUp();

        // Configurar o aplicativo para usar o driver 'testing' para Auth
        config(['auth.defaults.guard' => 'testing']);
    }

    public function test_realizar_Login_com_credenciais_corretas()
    {
        // Crie um usuário fictício
        $user = User::factory()->create([
            'cpf' => '12345678901', // Substitua pelo CPF real
            'password' => Hash::make('senha123'), // Substitua pela senha real
            'status' => 1,
        ]);

        // Crie uma instância falsa de PublicacoesRepository
        $publicacoesRepository = $this->createMock(PublicacoesRepository::class);

        // Crie uma instância do controlador, passando o PublicacoesRepository falso
        $loginController = new LoginController($publicacoesRepository);

        // Crie uma solicitação falsa com CPF e senha corretos
        $request = new \Illuminate\Http\Request([
            'cpf' => '123.456.789-01', // Substitua pelo CPF real
            'password' => 'senha123', // Substitua pela senha real
        ]);

        // Autentique o usuário manualmente
        Auth::login($user);

        // Chame a função realizar_Login
        $response = $loginController->realizar_Login($request);

        // Verifique se o redirecionamento é bem-sucedido
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals('/welcome', $response->getTargetUrl());

        // Verifique se a sessão contém informações corretas do usuário
        $this->assertEquals($user->ID, session('user_id'));
        $this->assertEquals($user->nome, session('user_name'));
        $this->assertEquals($user->tipousuario, session('user_tipousuario'));
        $this->assertEquals($user->status, session('user_status'));
    }

    // Teste outras condições, como CPF ou senha incorretos, usuário inativo, etc.
}
