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
    use WithFaker;

    /**
     * Testar login com cpf e senha válidos.
     *
     * @return void
     */

    public function test_telainicial_Login_() : void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
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
        $this->assertNotEquals(0, $status, 'Usuário ativo'); 
    }

}
