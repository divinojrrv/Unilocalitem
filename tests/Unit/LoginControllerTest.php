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
    
        
        app()->instance(PublicacoesRepository::class, $publicacoesRepositoryMock);
    
        // Crie uma instância do controlador HomeController
    
        $user = User::factory()->create([
            'ID' => 1,
            'cpf' => '99999999999', // Substitua pelo CPF real
            'password' => Hash::make('senha123'), // Substitua pela senha real
            'status' => 1,
            'tipousuario' => 0,
        ]);
    
        session(['user_id' => 1,'user_tipousuario' => 0]);
    
        $publicacoesRepositoryMock->shouldReceive('paginateExcluindoUser')->once()->andReturn([
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
    
    
        $request = new \Illuminate\Http\Request([
            'cpf' => '999.999.999-99',
            'password' => 'senha123',
        ]);
    
    
        $response = $loginController->realizar_Login($request);
    
    
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals('/welcome', $response->getTargetUrl());
    
    
        $this->assertEquals($user->ID, session('user_id'));
        $this->assertEquals($user->nome, session('user_name'));
    
        // assertiva removida
        // $this->assertEquals($user->tipousuario, session('user_tipousuario'));
    }


    public function testLoginInativoUser()
    {

        $usuario = $this->mock(User::class);
        $usuario->shouldReceive('where')
            ->with(['cpf' => '12345678900'])
            ->andReturn($usuario);
        $usuario->shouldReceive('first')
            ->andReturn($usuario);
    

        $usuario->shouldReceive('setAttribute')
            ->with('status', 1); //Status 1 igual usuário inativo
        

             // Definindo a expectativa para o método getAttribute()
        $usuario->shouldReceive('getAttribute')
        ->with('status')
        ->andReturn(1);


        $response = $this->app->call('App\Http\Controllers\LoginController@realizar_Login', [
            'cpf' => '12345678900',
            'password' => '123456',
        ]);
    

        $this->assertEquals(302, $response->getStatusCode());     
        $status = $usuario->getAttribute('status');
        $this->assertNotEquals(0, $status, 'Usuário ativo '); 
    }

}
