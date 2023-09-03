<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categorias')->insert([
            'ID' => 1,
            'nome' => 'LAPIS',
        ]);
        DB::table('categorias')->insert([
            'ID' => 2,
            'nome' => 'GARRAFA DE ÁGUA',
        ]);
        DB::table('categorias')->insert([
            'ID' => 3,
            'nome' => 'BOLSA',
        ]);
    }
}
