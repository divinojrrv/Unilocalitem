<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImagensRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Defina aqui as permissões de autorização, se necessário.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'nome' => 'required',
            'extensao' => 'required',
            'caminho' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'nome.required' => 'O nome é obrigatório.',
            'extensao.required' => 'A extensão é obrigatória.',
            'caminho.required' => 'O caminho é obrigatório.',
        ];
    }
}
