<?php

namespace Tests\Unit;


use GuzzleHttp\Psr7\Request;
use Mockery;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Factories\UserFactory;
use App\Http\Controllers\Controller\UserController;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;


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
}
