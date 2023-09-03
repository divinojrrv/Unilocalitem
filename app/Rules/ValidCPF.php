<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ValidCPF implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Remover caracteres não numéricos
        $cpf = preg_replace('/[^0-9]/', '', $value);

        

        // Verificar se o CPF possui 11 dígitos
        if (strlen($cpf) != 11) {
            return false;
        }



        // Verificar se todos os dígitos são iguais (CPF inválido)
        //if (preg_match('/(\d)\1{10}/', $cpf)) {
        //    return false;
        //}

        // Calcular o primeiro dígito verificador
        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += intval($cpf[$i]) * (10 - $i);
        }
        $remainder = $sum % 11;
        $digit1 = ($remainder < 2) ? 0 : 11 - $remainder;

        // Calcular o segundo dígito verificador
        $sum = 0;
        for ($i = 0; $i < 10; $i++) {
            $sum += intval($cpf[$i]) * (11 - $i);
        }
        $remainder = $sum % 11;
        $digit2 = ($remainder < 2) ? 0 : 11 - $remainder;

        // Verificar se os dígitos verificadores estão corretos
        if ($cpf[9] != $digit1 || $cpf[10] != $digit2) {
            return false;
        }

        // Verificar se o CPF já existe no banco de dados
        return !User::where('cpf', $cpf)->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O CPF informado não é válido ou já está cadastrado no sistema.';
    }
}
