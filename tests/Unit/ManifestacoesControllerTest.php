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
use App\Models\Manifestacoes;
use App\Repositories\PublicacoesRepository;
use App\Repositories\UsuarioRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ResgatesController;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\Factory;

class ManifestacoesControllerTest extends TestCase
{
    use RefreshDatabase;
/**
     * @test
     */
    public function testManifestarPublicacao_altera_status()
    {
        // Use a fábrica para criar uma publicação simulada no banco de dados de teste
        $publicacao = Publicacoes::factory()->create(['id' => 5,'STATUS' => HomeController::PUBLI_RESGTCONCLU,]);

        // Altere o status da publicação para RESGTCONCLU
         $publicacao->update(['STATUS' => HomeController::PUBLI_MANIFESTADA]);

        $this->assertEquals(HomeController::PUBLI_MANIFESTADA, $publicacao->STATUS);

    }

/**
     * @test
     */
    public function testManifestarPublicacao_deve_criar_registro_tabela_manifestacoes()
    {
        // Use a fábrica para criar uma publicação simulada no banco de dados de teste
        $publicacao = Publicacoes::factory()->create(['id' => 7,'STATUS' => HomeController::PUBLI_RESGTCONCLU,]);

        $manifestacoes = Manifestacoes::factory()->create(['IDPUBLICACAO' => $publicacao->id,'IDUSUARIO' => 1]);

        // Verifique se um registro foi criado na tabela `devolvidos`
        $this->assertDatabaseHas('manifestacoes', [
        'IDPUBLICACAO' => $publicacao->id,
        ]);

        // Verifique o ID do registro criado na tabela `devolvidos`
        $devolvidos = Manifestacoes::where('IDPUBLICACAO', $publicacao->id)->first();
        $this->assertEquals(1, $devolvidos->ID);

    }

/**
     * @test
     */
    public function testManifestaAceitar()
    {
        // Use a fábrica para criar uma publicação simulada no banco de dados de teste
        $publicacao = Publicacoes::factory()->create(['id' => 5,'STATUS' => HomeController::PUBLI_MANIFESTADA,]);

        // Altere o status da publicação para RESGTCONCLU
         $publicacao->update(['STATUS' => HomeController::PUBLI_MANIFESTADACONCLUIDA]);

        $this->assertEquals(HomeController::PUBLI_MANIFESTADACONCLUIDA, $publicacao->STATUS);
    }
/**
     * @test
     */
    public function testManifestaRecusar()
    {
        // Use a fábrica para criar uma publicação simulada no banco de dados de teste
        $publicacao = Publicacoes::factory()->create(['id' => 6,'STATUS' => HomeController::PUBLI_MANIFESTADA,]);

        // Altere o status da publicação para RESGTCONCLU
         $publicacao->update(['STATUS' => HomeController::PUBLI_RESGTCONCLU]);

        $this->assertEquals(HomeController::PUBLI_RESGTCONCLU, $publicacao->STATUS);
    }
}
