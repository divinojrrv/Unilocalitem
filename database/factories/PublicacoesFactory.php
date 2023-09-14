<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Publicacoes>
 */
class PublicacoesFactory extends Factory
{
    /**
     * Define o modelo que a fábrica deve usar.
     *
     * @var string
     */
    protected $model = Publicacoes::class;

    /**
     * Define o estado padrão para o modelo recém-criado.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'NOME' => $this->faker->sentence,
            'DESCRICAO' => $this->faker->paragraph,
            'DATAHORA' => now(),
            'STATUS' => 1,
            'IDCATEGORIA' => function () {
                // Você pode personalizar a lógica aqui para atribuir uma categoria específica
                return \App\Models\Categoria::factory()->create()->ID;
            },
            'IDBLOCO' => function () {
                // Você pode personalizar a lógica aqui para atribuir um bloco específico
                return \App\Models\Bloco::factory()->create()->ID;
            },
            'IDUSUARIO' => function () {
                // Você pode personalizar a lógica aqui para atribuir um usuário específico
                return \App\Models\User::factory()->create()->id;
            },
        ];
    }
}