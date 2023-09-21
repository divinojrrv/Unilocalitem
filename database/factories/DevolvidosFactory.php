<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\Devolvidos;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Devolvidos>
 */
class DevolvidosFactory extends Factory
{    
    /**
    * Define o modelo que a fábrica deve usar.
    *
    * @var string
    */
   protected $model = Devolvidos::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'DATAHORA' => now(),
            'IDUSUARIO' => $this->faker->numberBetween(1, 100),
            'IDPUBLICACAO' => $this->faker->numberBetween(1, 100),
        ];
    }
}