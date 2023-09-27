<?php

namespace Tests\Unit;


use GuzzleHttp\Psr7\Request;
use Illuminate\Contracts\Hashing\Hasher;
use Mockery;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Factories\UserFactory;
use App\Http\Controllers\Controller\UserController;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;
    private Hasher $hasher;

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

    public function testEditUser()
    {
        $usuarioController = new \App\Http\Controllers\UserController();

        $usuarioMock = Mockery::mock(User::class);
        $usuarioMock->shouldReceive('find')->with(1)->andReturn($usuarioMock);

        // Criar um usuário falso usando o método `make()` da factory
        $usuarioMock = UserFactory::new()->make([
            'nome' => 'João da Silva',
            'cpf' => '6232683323',
            'email' => 'joao@silva.com',
            'password' => '123456',
            'tipousuario' => '0',
            'status' => '1',
            'remember_token' => 'sRdWfajE9y',
            'name' => 'João da Silva',
            'updated_at' => '2023-09-27 00:30:41',
            'created_at' => '2023-09-27 00:30:41',
        ]);


        // Chamar a função `edit()` e verificar o retorno
        $response = $usuarioController->edit(1, $usuarioMock);

        $this->assertNotNull($response);
    }


    public function testEditADMUser()
    {
        $usuarioController = new \App\Http\Controllers\UserController();

        $usuarioMock = Mockery::mock(User::class);
        $usuarioMock->shouldReceive('find')->with(1)->andReturn($usuarioMock);

        // Criar um usuário falso usando o método `make()` da factory
        $usuarioMock = UserFactory::new()->make([
            'nome' => 'João da Silva',
            'cpf' => '6232683323',
            'email' => 'joao@silva.com',
            'password' => '123456',
            'tipousuario' => '0',
            'status' => '1',
            'remember_token' => 'sRdWfajE9y',
            'name' => 'João da Silva',
            'updated_at' => '2023-09-27 00:30:41',
            'created_at' => '2023-09-27 00:30:41',
        ]);


        // Chamar a função `edit()` e verificar o retorno
        $response = $usuarioController->editADM(1, $usuarioMock);

        $this->assertNotNull($response);
    }


    public function setHasher(Hasher $hasher)
    {
        $this->hasher = $hasher;
    }
    
    public function testAtualizaNomeDeUsuarioComSucesso()
    {
        $usuario = UserFactory::new()->make([
            'nome' => 'João da Silva',
            'cpf' => '6232683323',
            'email' => 'joao@silva.com',
            'password' => '123456',
            'tipousuario' => '0',
            'status' => '1',
            'remember_token' => 'sRdWfajE9y',
            'name' => 'João da Silva',
            'updated_at' => '2023-09-27 00:30:41',
            'created_at' => '2023-09-27 00:30:41',
        ]);

        $request = Mockery::mock(Request::class);
        $request->shouldReceive('input')->with('nome')->andReturn('Novo Nome');
        $request->shouldReceive('input')->with('password')->andReturn('123456');

        $hasher = Mockery::mock(Hash::class);
        $hasher->shouldReceive('check')->with('123456', $usuario->password)->andReturn(true);

        $usuarioController = new \App\Http\Controllers\UserController();


        $response = $usuarioController->update($request, $usuario->id);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals('Nome de usuário atualizado com sucesso', session('success'));

        $usuario->refresh();
        $this->assertEquals('Novo Nome', $usuario->nome);
    }

    public function testFalhaAtualizaNomeDeUsuarioPorSenhaIncorreta()
    {
        $usuario = UserFactory::new()->make([
            'nome' => 'João da Silva',
            'cpf' => '6232683323',
            'email' => 'joao@silva.com',
            'password' => '123456',
            'tipousuario' => '0',
            'status' => '1',
            'remember_token' => 'sRdWfajE9y',
            'name' => 'João da Silva',
            'updated_at' => '2023-09-27 00:30:41',
            'created_at' => '2023-09-27 00:30:41',
        ]);

        $request = Mockery::mock(Request::class);
        $request->shouldReceive('input')->with('nome')->andReturn('Novo Nome');
        $request->shouldReceive('input')->with('password')->andReturn('123456789');

        $hasher = Mockery::mock(Hash::class);
        $hasher->shouldReceive('check')->with('123456789', $usuario->password)->andReturn(false);

        $usuarioController = new \App\Http\Controllers\UserController();


        $response = $usuarioController->update($request, $usuario->id);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals('Senha incorreta. Não foi possível atualizar o nome.', session('error'));
    }
}
