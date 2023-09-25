<?php

namespace Tests\Unit;



use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;


class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_telaCadastro_rendered(): void
    {
        $response = $this->get('/Usuario/CadastrarUser');

        $response->assertStatus(200);
    }

    public function test_register(): void
    {
        $response = $this->post('/Usuario', [
            'id' => 1,
            'nome' => 'Test User',
            'cpf' => '35178114086',
            'email' => 'test@example.com',
            'password' => Hash::make(trim('12345678')),
            'tipousuario' => 0,
            'status' => 1,
        ]);


        $response->assertRedirect(RouteServiceProvider::HOME);
        
    }
}
