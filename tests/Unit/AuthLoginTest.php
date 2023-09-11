<?php

namespace Tests\Unit;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AuthLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
       $user = User::factory()->create();
 /*
        Teste manualmente
        $response = $this->followingRedirects()->post('/Home', [
            'cpf' => $user->cpf,
            'password' => 'password',
        ]);
    
        $response->assertStatus(200); // Verifique se o redirecionamento foi bem-sucedido
    */

        $response = $this->post('/Home', [
            'cpf' => $user->cpf,
            'password' => 'password',
        ]);

        $this->assertAuthenticated(); // Verifica se o usuário está autenticado corretamente
        $response->assertRedirect(route('/Home')); // Use a função route() para gerar a URL da rota nomeada

        //$response = $this->get('/Home');
        //$response->assertStatus(200);       
    
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/Home', [
            'cpf' => $user->cpf,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }
}
