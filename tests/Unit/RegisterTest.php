<?php

namespace Tests\Unit;



use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/Usuario/CadastrarUser');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/Usuario/CadastrarUser', [
            'nome' => 'Test User',
            'cpf' => '35178114086',
            'email' => 'test@example.com',
            'password' => Hash::make(trim('12345678')),
            'tipousuario' => 0,
            'status' => 1,
        ]);

        //$this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
        
    }
}
