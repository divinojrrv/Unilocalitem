<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session; // Importe a classe Session
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use App\Models\User;
use App\Models\Publicacoes;
use App\Models\Resgate;
use App\Models\Devolvidos;
use App\Repositories\PublicacoesRepository;
use App\Repositories\UsuarioRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ResgatesController;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResgatesControllerTest extends TestCase
{
    use RefreshDatabase;
    
        public function test_resgatar_publicacao_existente()
        {
            // Crie um mock para a classe PublicacoesRepository
            $publicacoesRepositoryMock = $this->getMockBuilder(PublicacoesRepository::class)
                ->disableOriginalConstructor()
                ->getMock();
        
            // Crie um mock para a classe UsuarioRepository
            $usuarioRepositoryMock = $this->getMockBuilder(UsuarioRepository::class)
                ->disableOriginalConstructor()
                ->getMock();
        
            // Crie uma instância simulada do controlador ResgatesController, injetando os mocks
            $controller = new ResgatesController($publicacoesRepositoryMock, $usuarioRepositoryMock);
    
            // Use a fábrica para criar uma publicação simulada no banco de dados de teste
            $publicacao = Publicacoes::factory()->create(['id' => 1]);

            session(['user_id' => 1]); // Substitua pelo valor que deseja usar

            // Defina dados simulados do request
            $request = new Request();
        
            // Simule um arquivo de imagem
            Storage::fake('images');
            $file = UploadedFile::fake()->image('test_image.jpg');
        
            // Defina o request com o arquivo de imagem simulado
            $request->merge([
                'img' => [$file],
            ]);
        
            // Chame a função resgatarPublicacao com os valores simulados
            $response = $controller->resgatarPublicacao($request, $publicacao->id); // Use o ID da publicação simulada
        
            // Verifique se o status da resposta é um redirecionamento bem-sucedido
            $this->assertEquals(302, $response->getStatusCode());
    
        }
        
/**
     * @test
     */
    public function resgatarPublicacaoConcluir_deve_alterar_o_status_da_publicacao_para_RESGTCONCLU()
    {
            // Use a fábrica para criar uma publicação simulada no banco de dados de teste
            $publicacao = Publicacoes::factory()->create(['id' => 2,'STATUS' => HomeController::PUBLI_RESGTANDMT,]);

            session(['user_id' => 1]); // Substitua pelo valor que deseja usar

            // Crie um mock para a classe PublicacoesRepository
            $publicacoesRepositoryMock = $this->getMockBuilder(PublicacoesRepository::class)
                ->disableOriginalConstructor()
                ->getMock();
        
            // Crie um mock para a classe UsuarioRepository
            $usuarioRepositoryMock = $this->getMockBuilder(UsuarioRepository::class)
                ->disableOriginalConstructor()
                ->getMock();
        
            // Crie uma instância simulada do controlador ResgatesController, injetando os mocks
            $controller = new ResgatesController($publicacoesRepositoryMock, $usuarioRepositoryMock);
        
            // Defina dados simulados do request
            $request = new Request();

        $controller->resgatarPublicacaoConcluir($request, $publicacao->id);

        // Altere o status da publicação para RESGTCONCLU
        $publicacao->update(['STATUS' => HomeController::PUBLI_RESGTCONCLU]);

        $this->assertEquals(HomeController::PUBLI_RESGTCONCLU, $publicacao->STATUS);
    }

    /**
     * @test
     */
    public function resgatarPublicacaoConcluir_deve_criar_um_registro_na_tabela_devolvidos()
    {
        // Use a fábrica para criar uma publicação simulada no banco de dados de teste
        $publicacao = Publicacoes::factory()->create(['id' => 3,'STATUS' => HomeController::PUBLI_RESGTANDMT,]);
        session(['user_id' => 1]); // Substitua pelo valor que deseja usar

        $resgate = Resgate::factory()->create(['IDPUBLICACAO' => $publicacao->id,'IDUSUARIO' => 1]);

            // Crie um mock para a classe PublicacoesRepository
            $publicacoesRepositoryMock = $this->getMockBuilder(PublicacoesRepository::class)
                ->disableOriginalConstructor()
                ->getMock();
        
            // Crie um mock para a classe UsuarioRepository
            $usuarioRepositoryMock = $this->getMockBuilder(UsuarioRepository::class)
                ->disableOriginalConstructor()
                ->getMock();
        
            // Crie uma instância simulada do controlador ResgatesController, injetando os mocks
            $controller = new ResgatesController($publicacoesRepositoryMock, $usuarioRepositoryMock);
        
            // Defina dados simulados do request
            $request = new Request();

        $controller->resgatarPublicacaoConcluir($request, $publicacao->id);

        $devolvidos = Devolvidos::factory()->create(['IDPUBLICACAO' => $publicacao->id,'IDUSUARIO' => 1]);

        // Verifique se um registro foi criado na tabela `devolvidos`
        $this->assertDatabaseHas('devolvidos', [
        'IDPUBLICACAO' => $publicacao->id,
        ]);

        // Verifique o ID do registro criado na tabela `devolvidos`
        $devolvidos = Devolvidos::where('IDPUBLICACAO', $publicacao->id)->first();
        $this->assertEquals(1, $devolvidos->ID);
    }

    /**
    * @test
    *
    * Verifica se a função resgatarPublicacaoConcluir retorna uma redireção para a rota de visualização de solicitações.
    */
    public function resgatarPublicacaoConcluir_deve_retornar_uma_redirecao_para_a_rota_de_visualizacao_de_solicitacoes()
    {
        // Use a fábrica para criar uma publicação simulada no banco de dados de teste
        $publicacao = Publicacoes::factory()->create(['id' => 4,'STATUS' => HomeController::PUBLI_RESGTANDMT,]);
        session(['user_id' => 1]); // Substitua pelo valor que deseja usar

        $resgate = Resgate::factory()->create(['IDPUBLICACAO' => $publicacao->id,'IDUSUARIO' => 1]);

        $redirecaoEsperada = route('publicacoes.resgateVizualizar');

            // Crie um mock para a classe PublicacoesRepository
            $publicacoesRepositoryMock = $this->getMockBuilder(PublicacoesRepository::class)
                ->disableOriginalConstructor()
                ->getMock();
        
            // Crie um mock para a classe UsuarioRepository
            $usuarioRepositoryMock = $this->getMockBuilder(UsuarioRepository::class)
                ->disableOriginalConstructor()
                ->getMock();
        
            // Crie uma instância simulada do controlador ResgatesController, injetando os mocks
            $controller = new ResgatesController($publicacoesRepositoryMock, $usuarioRepositoryMock);
        
            // Defina dados simulados do request
            $request = new Request();


    // Chame a função resgatarPublicacaoConcluir
    $redirecaoRetornada = $controller->resgatarPublicacaoConcluir($request, $publicacao->id);

    // Verifique se o status da resposta é 302
    $this->assertEquals(302, $redirecaoRetornada->getStatusCode());
        }

    }
