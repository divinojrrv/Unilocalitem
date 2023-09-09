<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->name(),
            'cpf' => $this->generateFakeCpf(), // Use uma função personalizada para gerar CPFs falsos
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // Você pode usar o Hash::make para criar senhas criptografadas
            'tipousuario' => 0,
            'status' => 1,
            'remember_token' => Str::random(10),
        ];
    }
    
    private function generateFakeCpf(): string
    {
        $cpf = '';
        for ($i = 0; $i < 9; $i++) {
            $cpf .= mt_rand(0, 9);
        }
        $cpfNumbers = str_split($cpf);
        $sum = 0;
        $weights = [10, 9, 8, 7, 6, 5, 4, 3, 2];
        for ($i = 0; $i < 9; $i++) {
            $sum += $cpfNumbers[$i] * $weights[$i];
        }
        $remainder = $sum % 11;
        if ($remainder < 2) {
            $cpf .= '0';
        } else {
            $cpf .= (11 - $remainder);
        }
        return $cpf;
    }
    




    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
