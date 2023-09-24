<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\UserController;
use Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var MockInterface
     */
    private $userMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userMock = Mockery::mock(User::class);
    }

    public function testEdit()
    {
        $user = new User();
        $user->id = 1;
        $user->name = 'John Doe';

        $this->userMock->shouldReceive('find')->with(1)->andReturn($user);

        $response = $this->get('/usuario/alteraruser/1');

        $response->assertStatus(200);
        $response->assertViewIs('Usuario.alteraruser');
        $response->assertViewHas('usuario', $user);
    }

    public function testEditADM()
    {
        $user = new User();
        $user->id = 1;
        $user->name = 'John Doe';

        $this->userMock->shouldReceive('find')->with(1)->andReturn($user);

        $response = $this->get('/usuario/alteraruserADM/1');

        $response->assertStatus(200);
        $response->assertViewIs('Usuario.alteraruserADM');
        $response->assertViewHas('usuario', $user);
    }

    public function testUpdateADM()
    {
        $user = new User();
        $user->id = 1;
        $user->name = 'John Doe';

        $this->userMock->shouldReceive('find')->with(1)->andReturn($user);
        $this->userMock->shouldReceive('save')->andReturn(true);

        $request = $this->post('/usuario/atualizarADM/1', [
            'nome' => 'Jane Doe',
            'password' => 'password',
            'password_confirmation' => 'password',
            'tipousuario' => 1,
            'status' => 0,
        ]);

        $request->assertStatus(302);
        $request->assertRedirect('/usuario/telainicial');
        $request->assertSessionHas('success', 'Usuário atualizado com sucesso');
    }

    public function testUpdate()
    {
        $user = new User();
        $user->id = 1;
        $user->name = 'John Doe';
        $user->password = Hash::make('password');

        $this->userMock->shouldReceive('find')->with(1)->andReturn($user);
        $this->userMock->shouldReceive('save')->andReturn(true);

        $request = $this->post('/usuario/atualizar/1', [
            'nome' => 'Jane Doe',
            'password' => 'password',
        ]);

        $request->assertStatus(302);
        $request->assertRedirect('/usuario/telainicial');
        $request->assertSessionHas('success', 'Nome de usuário atualizado com sucesso');
    }
}
