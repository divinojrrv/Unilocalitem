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
use App\Http\Requests\PublicacoesRequest;
use Mockery;
use App\Models\Publicacoes;
use Illuminate\Http\RedirectResponse;
use App\Models\Imagens;
use Illuminate\Http\Request;


class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get(route('publicacoes.sget'));

        $response->assertStatus(302);
    }

    public function test_Registrando_new_publis()
    {
        // Crie uma Simulação (Mock) para a classe PublicacoesRepository
        $publicacoesRepositoryMock = Mockery::mock(PublicacoesRepository::class);

        // Defina o comportamento esperado para o método store
        $publicacoesRepositoryMock
            ->shouldReceive('store')
            ->once()
            ->andReturn(new Publicacoes());


        // Crie uma instância simulada de PublicacoesRequest
        $publicacoesRequestMock = Mockery::mock(PublicacoesRequest::class);

        // Defina o comportamento esperado para o método validated
        $publicacoesRequestMock->shouldReceive('validated')->andReturn([
            'NOME' => 'Título da Publicação',
            'DESCRICAO' => 'Descrição da Publicação',
            'DATAHORA' => 'now()->toIso8601String',
            'STATUS' => 3,
            'IDCATEGORIA' => 1,
            'IDBLOCO' => 1,
            'IDUSUARIO' => 1,
        ]);

        // Defina o comportamento esperado para o método hasFile
        $publicacoesRequestMock->shouldReceive('hasFile')->andReturn(false);

        // Configure o stub para o método NewImagems()
        $publicacoesRequestMock->shouldReceive('NewImagems')->andReturn(null);

        // Crie uma instância do HomeController, injetando o Mock do PublicacoesRepository
        $homeControllerMock = Mockery::mock(HomeController::class, [$publicacoesRepositoryMock])->makePartial();

        // Configure o stub para o método saveImagemObjeto()
        $homeControllerMock->shouldReceive('saveImagemObjeto')->andReturn(null);

        // Chame a função newPubli() com o mock do PublicacoesRequest
        $response = $homeControllerMock->NewPubli($publicacoesRequestMock);

        // Verifique se o método store foi chamado uma vez
        $publicacoesRepositoryMock
            ->shouldHaveReceived('store')
            ->once();

        // Verifique se o método NewImagems() não foi chamado
        $publicacoesRequestMock
            ->shouldNotHaveReceived('NewImagems');

    }

    public function test_Salvar_NewImagens()
    {
        // Crie uma instância simulada de PublicacoesRepository
        $publicacoesRepositoryMock = Mockery::mock(PublicacoesRepository::class);
        
        // Registre a instância simulada no container de serviços do aplicativo
        app()->instance(PublicacoesRepository::class, $publicacoesRepositoryMock);
    
        // Criar uma instância do controlador HomeController
        $controller = new HomeController($publicacoesRepositoryMock);
        
        // Definir um nome de arquivo simulado e extensão
        $filename = 'test_image.jpg';
    
        // Criar uma instância simulada de Request usando Mockery
        $uploadedFile = UploadedFile::fake()->create($filename, 0, 'image/jpeg');

        $requestMock = Mockery::mock(Request::class);

        $requestMock->shouldReceive('all')
        ->andReturn(['imagem' => $uploadedFile]);

        // Defina uma expectativa para o método route() retornar um valor simulado (pode ser null neste caso)
        $requestMock->shouldReceive('route')->andReturnNull();

        // Simular o comportamento de hasFile e isValid

        $requestMock->shouldReceive('hasFile')
            ->once()
            ->with('imagem')
            ->andReturn(true);
        
        $requestMock->shouldReceive('file')
            ->once()
            ->with('imagem')
            ->andReturn($uploadedFile);
    
        
        // Chamar a função NewImagems com os valores simulados
        $result = $controller->NewImagems(new Imagens(), $requestMock);
    
        // Verificar se a função retornou um ID válido (pode ser 1 no caso de simulação)
        $this->assertEquals(1, $result);

    }

    private function createUploadedFile($filename, $size = 0, $mimeType = 'image/jpeg')
    {
        $file = UploadedFile::fake()->create($filename, $size, $mimeType);
        Storage::fake('public\img\events'); // Use o disco de armazenamento que você deseja testar (no exemplo, 'public')
        Storage::disk('public\img\events')->putFileAs('', $file, $filename);

        return $file;
    }

    private function createTempFile()
    {
        $tempFile = tempnam(sys_get_temp_dir(), 'imagem');
        file_put_contents($tempFile, '');

        return $tempFile;
    }

    public function testRealizarConsulta_todos_os_filtros()
    {

        $publicacoesRepositoryMock = Mockery::mock(PublicacoesRepository::class);
        
        // Registre a instância simulada no container de serviços do aplicativo
        app()->instance(PublicacoesRepository::class, $publicacoesRepositoryMock);
    
        // Criar uma instância do controlador HomeController
        $controller = new HomeController($publicacoesRepositoryMock);

        // Crie uma instância simulada de Request
        $requestMock = Mockery::mock(Request::class);

        session(['user_id' => 1,'user_tipousuario' => 0]); // Substitua pelo valor que deseja usar

        // Defina o comportamento esperado para o método input
        $requestMock->shouldReceive('input')->andReturn([
            'datainicio' => '2023-08-01',
            'datafinal' => '2023-08-31',
            'IDCATEGORIA' => 1,
            'IDBLOCO' => 1,
            'status' => 3,
        ]);

        // Configure o stub para o método Consultar()
        $publicacoesRepositoryMock->shouldReceive('Consultar')->once()->andReturn([
            [
                'ID' => 1,
                'NOME' => 'Título da Publicação',
                'DESCRICAO' => 'Descrição da Publicação',
                'DATAHORA' => '2023-08-02',
                'STATUS' => 3,
                'IDCATEGORIA' => 1,
                'IDBLOCO' => 1,
            ],
        ]);

        // Chame a função `RealizarConsulta()` com o mock do Request
        $response = $controller->RealizarConsulta($requestMock);

        // Verifique se o método Consultar() foi chamado uma vez
        $publicacoesRepositoryMock->shouldHaveReceived('Consultar')->once();
    }

    public function testRealizarConsulta_PubliPendete()
    {

        $publicacoesRepositoryMock = Mockery::mock(PublicacoesRepository::class);
        
        // Registre a instância simulada no container de serviços do aplicativo
        app()->instance(PublicacoesRepository::class, $publicacoesRepositoryMock);
    
        // Criar uma instância do controlador HomeController
        $controller = new HomeController($publicacoesRepositoryMock);

        // Crie uma instância simulada de Request
        $requestMock = Mockery::mock(Request::class);

        session(['user_id' => 1,'user_tipousuario' => 0]); // Substitua pelo valor que deseja usar

        // Defina o comportamento esperado para o método input
        $requestMock->shouldReceive('input')->andReturn([
            'datainicio' => '2023-08-01',
            'datafinal' => '2023-08-31',
            'IDCATEGORIA' => 1,
            'IDBLOCO' => 1,
            'status' => 3,
        ]);

        // Configure o stub para o método Consultar()
        $publicacoesRepositoryMock->shouldReceive('Consultar')->once()->andReturn([
            [
                'ID' => 1,
                'NOME' => 'Título da Publicação',
                'DESCRICAO' => 'Descrição da Publicação',
                'DATAHORA' => '2023-08-02',
                'STATUS' => 1,
                'IDCATEGORIA' => 1,
                'IDBLOCO' => 1,
            ],
        ]);

        // Chame a função `RealizarConsulta()` com o mock do Request
        $response = $controller->RealizarConsulta($requestMock);

        // Verifique se o método Consultar() foi chamado uma vez
        $publicacoesRepositoryMock->shouldHaveReceived('Consultar')->once();
    }

    public function testRealizarConsulta_NaoAceita()
    {

        $publicacoesRepositoryMock = Mockery::mock(PublicacoesRepository::class);
        
        // Registre a instância simulada no container de serviços do aplicativo
        app()->instance(PublicacoesRepository::class, $publicacoesRepositoryMock);
    
        // Criar uma instância do controlador HomeController
        $controller = new HomeController($publicacoesRepositoryMock);

        // Crie uma instância simulada de Request
        $requestMock = Mockery::mock(Request::class);

        session(['user_id' => 1,'user_tipousuario' => 0]); // Substitua pelo valor que deseja usar

        // Defina o comportamento esperado para o método input
        $requestMock->shouldReceive('input')->andReturn([
            'datainicio' => '2023-08-01',
            'datafinal' => '2023-08-31',
            'IDCATEGORIA' => 1,
            'IDBLOCO' => 1,
            'status' => 3,
        ]);

        // Configure o stub para o método Consultar()
        $publicacoesRepositoryMock->shouldReceive('Consultar')->once()->andReturn([
            [
                'ID' => 1,
                'NOME' => 'Título da Publicação',
                'DESCRICAO' => 'Descrição da Publicação',
                'DATAHORA' => '2023-08-02',
                'STATUS' => 2,
                'IDCATEGORIA' => 1,
                'IDBLOCO' => 1,
            ],
        ]);

        // Chame a função `RealizarConsulta()` com o mock do Request
        $response = $controller->RealizarConsulta($requestMock);

        // Verifique se o método Consultar() foi chamado uma vez
        $publicacoesRepositoryMock->shouldHaveReceived('Consultar')->once();
    }

    public function testRealizarConsulta_ResgateEmAndamento()
    {

        $publicacoesRepositoryMock = Mockery::mock(PublicacoesRepository::class);
        
        // Registre a instância simulada no container de serviços do aplicativo
        app()->instance(PublicacoesRepository::class, $publicacoesRepositoryMock);
    
        // Criar uma instância do controlador HomeController
        $controller = new HomeController($publicacoesRepositoryMock);

        // Crie uma instância simulada de Request
        $requestMock = Mockery::mock(Request::class);

        session(['user_id' => 1,'user_tipousuario' => 0]); // Substitua pelo valor que deseja usar

        // Defina o comportamento esperado para o método input
        $requestMock->shouldReceive('input')->andReturn([
            'datainicio' => '2023-08-01',
            'datafinal' => '2023-08-31',
            'IDCATEGORIA' => 1,
            'IDBLOCO' => 1,
            'status' => 3,
        ]);

        // Configure o stub para o método Consultar()
        $publicacoesRepositoryMock->shouldReceive('Consultar')->once()->andReturn([
            [
                'ID' => 1,
                'NOME' => 'Título da Publicação',
                'DESCRICAO' => 'Descrição da Publicação',
                'DATAHORA' => '2023-08-02',
                'STATUS' => 4,
                'IDCATEGORIA' => 1,
                'IDBLOCO' => 1,
            ],
        ]);

        // Chame a função `RealizarConsulta()` com o mock do Request
        $response = $controller->RealizarConsulta($requestMock);

        // Verifique se o método Consultar() foi chamado uma vez
        $publicacoesRepositoryMock->shouldHaveReceived('Consultar')->once();
    }


    public function testRealizarConsulta_ResgateConcluido()
    {

        $publicacoesRepositoryMock = Mockery::mock(PublicacoesRepository::class);
        
        // Registre a instância simulada no container de serviços do aplicativo
        app()->instance(PublicacoesRepository::class, $publicacoesRepositoryMock);
    
        // Criar uma instância do controlador HomeController
        $controller = new HomeController($publicacoesRepositoryMock);

        // Crie uma instância simulada de Request
        $requestMock = Mockery::mock(Request::class);

        session(['user_id' => 1,'user_tipousuario' => 0]); // Substitua pelo valor que deseja usar

        // Defina o comportamento esperado para o método input
        $requestMock->shouldReceive('input')->andReturn([
            'datainicio' => '2023-08-01',
            'datafinal' => '2023-08-31',
            'IDCATEGORIA' => 1,
            'IDBLOCO' => 1,
            'status' => 3,
        ]);

        // Configure o stub para o método Consultar()
        $publicacoesRepositoryMock->shouldReceive('Consultar')->once()->andReturn([
            [
                'ID' => 1,
                'NOME' => 'Título da Publicação',
                'DESCRICAO' => 'Descrição da Publicação',
                'DATAHORA' => '2023-08-02',
                'STATUS' => 5,
                'IDCATEGORIA' => 1,
                'IDBLOCO' => 1,
            ],
        ]);

        // Chame a função `RealizarConsulta()` com o mock do Request
        $response = $controller->RealizarConsulta($requestMock);

        // Verifique se o método Consultar() foi chamado uma vez
        $publicacoesRepositoryMock->shouldHaveReceived('Consultar')->once();
    }

    public function testRealizarConsulta_PubliManifestada()
    {

        $publicacoesRepositoryMock = Mockery::mock(PublicacoesRepository::class);
        
        // Registre a instância simulada no container de serviços do aplicativo
        app()->instance(PublicacoesRepository::class, $publicacoesRepositoryMock);
    
        // Criar uma instância do controlador HomeController
        $controller = new HomeController($publicacoesRepositoryMock);

        // Crie uma instância simulada de Request
        $requestMock = Mockery::mock(Request::class);

        session(['user_id' => 1,'user_tipousuario' => 0]); // Substitua pelo valor que deseja usar

        // Defina o comportamento esperado para o método input
        $requestMock->shouldReceive('input')->andReturn([
            'datainicio' => '2023-08-01',
            'datafinal' => '2023-08-31',
            'IDCATEGORIA' => 1,
            'IDBLOCO' => 1,
            'status' => 3,
        ]);

        // Configure o stub para o método Consultar()
        $publicacoesRepositoryMock->shouldReceive('Consultar')->once()->andReturn([
            [
                'ID' => 1,
                'NOME' => 'Título da Publicação',
                'DESCRICAO' => 'Descrição da Publicação',
                'DATAHORA' => '2023-08-02',
                'STATUS' => 6,
                'IDCATEGORIA' => 1,
                'IDBLOCO' => 1,
            ],
        ]);

        // Chame a função `RealizarConsulta()` com o mock do Request
        $response = $controller->RealizarConsulta($requestMock);

        // Verifique se o método Consultar() foi chamado uma vez
        $publicacoesRepositoryMock->shouldHaveReceived('Consultar')->once();
    }

    public function testRealizarConsulta_PubliManifestadaConcluida()
    {

        $publicacoesRepositoryMock = Mockery::mock(PublicacoesRepository::class);
        
        // Registre a instância simulada no container de serviços do aplicativo
        app()->instance(PublicacoesRepository::class, $publicacoesRepositoryMock);
    
        // Criar uma instância do controlador HomeController
        $controller = new HomeController($publicacoesRepositoryMock);

        // Crie uma instância simulada de Request
        $requestMock = Mockery::mock(Request::class);

        session(['user_id' => 1,'user_tipousuario' => 0]); // Substitua pelo valor que deseja usar

        // Defina o comportamento esperado para o método input
        $requestMock->shouldReceive('input')->andReturn([
            'datainicio' => '2023-08-01',
            'datafinal' => '2023-08-31',
            'IDCATEGORIA' => 1,
            'IDBLOCO' => 1,
            'status' => 3,
        ]);

        // Configure o stub para o método Consultar()
        $publicacoesRepositoryMock->shouldReceive('Consultar')->once()->andReturn([
            [
                'ID' => 1,
                'NOME' => 'Título da Publicação',
                'DESCRICAO' => 'Descrição da Publicação',
                'DATAHORA' => '2023-08-02',
                'STATUS' => 7,
                'IDCATEGORIA' => 1,
                'IDBLOCO' => 1,
            ],
        ]);

        // Chame a função `RealizarConsulta()` com o mock do Request
        $response = $controller->RealizarConsulta($requestMock);

        // Verifique se o método Consultar() foi chamado uma vez
        $publicacoesRepositoryMock->shouldHaveReceived('Consultar')->once();
    }
}