<?php

namespace Tests\Unit;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get(route('publicacoes.sget'));

        $response->assertStatus(302);
    }

    public function test_new_publi_can_register(): void
    {
        $user = User::factory()->create(); // Crie um usuário fictício
        $this->actingAs($user); // Autentique o usuário

        $response = $this->post(route('publicacoes.store'), [
            'NOME' => 'Título da Publicação',
            'DESCRICAO' => 'Descrição da Publicação',
            'IDCATEGORIA' => 1, // Substitua pelo ID da categoria correto
            'IDBLOCO' => 1, // Substitua pelo ID do bloco correto
            'DATAHORA' => now(), // Use a data/hora atual
            'STATUS' => 3,
            'IDUSUARIO' => 1,
            'imagem' => UploadedFile::fake()->image('publicacao.jpg') // Substitua pelo arquivo de imagem correto
        ]);
<<<<<<< HEAD
/*
        $response = $controller->CadastrarPubli($request);

        $response->assertStatus(200); // Verifique o código de status apropriado
        $response->assertRedirect(route('/Publicacao/PubliPendentesUserComum')); // Use a função route() para gerar a URL da rota nomeada


        $response->assertSee('Publicações Pendentes');
        */

        }
}
=======


        $response->assertRedirect(route('publicacoes.pendentesView'));
    }
}
>>>>>>> 3424f59d6f1afff9d452f9671e9ab8acfbc5137d
