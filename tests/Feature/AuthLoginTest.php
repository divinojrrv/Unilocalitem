<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AuthLoginTest extends TestCase
{
    use RefreshDatabase;


    public function test_login(): void
    {

        $user = User::factory()->create([
            'cpf' => '99999999999',
            'password' => bcrypt('password'), 
        ]);

        $response = $this->get('/', [
            'cpf' => '99999999999',
            'password' => 'password',
        ]);

        $response->assertRedirect('/Home');


        //$this->assertAuthenticatedAs($user);
    }
}
