<?php

namespace Tests\Feature;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AuthLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login()
    {
        $user = User::factory()->create(); // Crie um usuário fictício

        // Faça uma solicitação POST para o endpoint de login personalizado
        $response = $this->post('/Home', [
            'cpf' => $user->cpf,
            'password' => 'password', // Substitua 'password' pela senha correta do usuário
        ]);

        $response->assertStatus(200);
        $response->assertRedirect(RouteServiceProvider::inicial);
    }
}
