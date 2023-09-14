<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session; // Importe a classe Session
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use App\Models\User;
use App\Models\Publicacoes;
use App\Repositories\PublicacoesRepository;
use App\Repositories\UsuarioRepository;
use Illuminate\Http\Request;
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
        
    }
