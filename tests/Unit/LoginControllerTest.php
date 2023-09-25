<?php

namespace App\Tests\Unit\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Mockery;
use Tests\TestCase;
use App\Http\Controllers\LoginController;
use App\Models\User;
use App\Repositories\PublicacoesRepository;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\RedirectResponse;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase; 

    public function test_telainicial_Login_() : void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function test_realizar_Login_com_credenciais_corretas()
    {
        $publicacoesRepositoryMock = Mockery::mock(PublicacoesRepository::class);
    
        // Registre a instância simulada no container de serviços do aplicativo
        app()->instance(PublicacoesRepository::class, $publicacoesRepositoryMock);
    
        // Crie uma instância do controlador HomeController
    
        $user = User::factory()->create([
            'ID' => 1,
            'cpf' => '99999999999', // Substitua pelo CPF real
            'password' => Hash::make('senha123'), // Substitua pela senha real
            'status' => 1,
            'tipousuario' => 1,
        ]);
    

        $publicacoesRepositoryMock->shouldReceive('paginateTodasPubli')->once()->andReturn([
            [
                'ID' => 1,
                'NOME' => 'Título da Publicação',
                'DESCRICAO' => 'Descrição da Publicação',
                'DATAHORA' => '2023-08-02',
                'STATUS' => 7,
                'IDCATEGORIA' => 1,
                'IDBLOCO' => 1,
            ],
        ]);

    
    
        $loginController = new LoginController($publicacoesRepositoryMock);
    
        // Crie uma solicitação falsa com CPF e senha corretos
        $request = new \Illuminate\Http\Request([
            'cpf' => '999.999.999-99', // Substitua pelo CPF real
            'password' => 'senha123', // Substitua pela senha real
        ]);
    
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

}
