<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\Categoria;
use App\Models\Bloco;

class CadastrarPubli extends TestCase
{
    use RefreshDatabase;

    public function testCadastrarNovaPublicacao()
    {
        Storage::fake('public'); // Configura o sistema de armazenamento para não salvar arquivos no disco
    
        $categoria = Categoria::factory()->create();
        $bloco = Bloco::factory()->create();
    
        $data = [
            'NOME' => 'Título da Publicação',
            'DESCRICAO' => 'Descrição da Publicação',
            'IDCATEGORIA' => $categoria->ID,
            'IDBLOCO' => $bloco->ID,
            'DATAHORA' => now()->format('Y-m-d\TH:i'),
            'imagem' => UploadedFile::fake()->image('publicacao.jpg'), // Imagem fake para teste
            'IDUSUARIO' => 1, // Defina o ID do usuário conforme necessário
            'STATUS' => 1,
        ];
    
        $response = $this->post(route('publicacoes.store'), $data);
    
        $response->assertStatus(302); // Verifica se a resposta é um redirecionamento após o cadastro
        $response->assertRedirect(route('usuario.telainicial')); // Verifica se o redirecionamento está correto
    
        // Verifica se a publicação foi criada no banco de dados
        $this->assertDatabaseHas('publicacoes', [
            'NOME' => 'Título da Publicação',
            'DESCRICAO' => 'Descrição da Publicação',
            'IDCATEGORIA' => $categoria->ID,
            'IDBLOCO' => $bloco->ID,
            'IDUSUARIO' => 1, // Defina o ID do usuário conforme necessário
            'STATUS' => 1,
        ]);
    
        // Armazena o arquivo falso no sistema de arquivos falso (Storage::fake)
        Storage::disk('public')->putFileAs('imagens', $data['imagem'], $data['imagem']->hashName());
    
        // Agora, verifique se a imagem existe no sistema de arquivos
        Storage::disk('public')->assertExists('imagens/' . $data['imagem']->hashName());
    }
    
}
