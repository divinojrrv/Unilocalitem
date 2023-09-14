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
use App\Repositories\PublicacoesRepository;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\HomeController;
use Mockery;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get(route('publicacoes.sget'));

        $response->assertStatus(302);
    }

    public function test_new_publi_can_register()
    {

        // Simule a autenticação e defina a sessão 'user_tipousuario'
        Session::start();
        Session::put('user_tipousuario', HomeController::USERCOMUM); // OU HomeController::USERCOMUM, dependendo do cenário

                
        // Crie um Mock para a classe PublicacoesRepository
        $publicacoesRepositoryMock = Mockery::mock(\App\Repositories\PublicacoesRepository::class);

        // Defina o comportamento do método store
        $publicacoesRepositoryMock
            ->shouldReceive('store')
            ->once()
            ->andReturn(true); // ou false, dependendo do cenário de teste

        // Substitua a instância real do repositório pela instância de Mock somente durante este teste
        $this->app->bind(\App\Repositories\PublicacoesRepository::class, function () use ($publicacoesRepositoryMock) {
            return $publicacoesRepositoryMock;
        });

        // Crie um arquivo de imagem falso
        $file = UploadedFile::fake()->image('publicacao.jpg');

        // Simule o armazenamento do arquivo falso
        Storage::fake('publications');
        Storage::disk('publications')->putFileAs('', $file, 'publicacao.jpg');

        // Agora, você pode chamar a rota ou o método NewPubli para executar o teste
        $response = $this->post(route('publicacoes.store'), [
            'NOME' => 'Título da Publicação',
            'DESCRICAO' => 'Descrição da Publicação',
            'IDCATEGORIA' => 1,
            'IDBLOCO' => 1,
            'DATAHORA' => now(),
            'STATUS' => 3,
            'IDUSUARIO' => 1,
            'imagem' => $file // Use o arquivo de imagem falso
        ]);

        // Verifique o resultado da chamada do método
        $response->assertRedirect(route('publicacoes.pendentesView'));
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }
}