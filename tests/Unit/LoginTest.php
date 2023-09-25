<?php


namespace App\Tests\Unit\Controllers;

use App\Http\Controllers\LoginController;
use App\Models\User;
use Auth;
use Mockery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;


    public function test_realizar_login_com_cpf_invalido()
    {
       
        $user = User::factory()->create();


        $response = $this->post('/Home', [
            'cpf' => '12345678901',
            'password' => 'password',
        ]);
        $response->assertRedirect('/');
    }
}
