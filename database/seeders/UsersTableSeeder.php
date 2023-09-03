<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'ID' => 1,
            'nome' => 'ADM',
            'cpf' => '99999999999',
            'email' => 'adm@gmail.com',
            'password' => Hash::make(trim('12345678')),
            'tipousuario' => 1,
            'status' => 1,
        ]);
    }
}
