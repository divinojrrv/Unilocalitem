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
        $user = User::factory()->create(); 


        $response = $this->post('/Home', [
            'cpf' => $user->cpf,
            'password' => 'password', 
        ]);


        $response->assertRedirect(RouteServiceProvider::inicial);
    }
}
