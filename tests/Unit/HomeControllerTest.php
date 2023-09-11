<?php

namespace Tests\Unit;

use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use App\Repositories\PublicacoesRepository;
use App\Models\Publicacoes; 

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Providers\RouteServiceProvider;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Log;


class HomeControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     */
    public function testViewRender(){
        
        // Crie uma instância de Publicacoes
        $publicacoesModel = new Publicacoes(); // Certifique-se de ajustar isso conforme a estrutura do seu projeto

        // Crie uma instância de PublicacoesRepository e passe a instância de Publicacoes
        $publicacoesRepository = new PublicacoesRepository($publicacoesModel);

        // Crie uma instância do HomeController e passe a instância de PublicacoesRepository
        $controller = new HomeController($publicacoesRepository);

        // Crie uma instância de Request com os dados que você deseja testar
        $request = new Request([
            'NOME' => 'Teste de Título',
            'DESCRICAO' => 'Teste de Descrição',
            'IDCATEGORIA' => 1, // Substitua pelo valor correto
            'IDBLOCO' => 1, // Substitua pelo valor correto
            'DATAHORA' => '2023-09-10T12:00', // Substitua pela data/hora correta
            // Adicione outros campos necessários
        ]);
/*
        $response = $controller->CadastrarPubli($request);

        $response->assertStatus(200); // Verifique o código de status apropriado
        $response->assertRedirect(route('/Publicacao/PubliPendentesUserComum')); // Use a função route() para gerar a URL da rota nomeada


        $response->assertSee('Publicações Pendentes');
        */

        }
}