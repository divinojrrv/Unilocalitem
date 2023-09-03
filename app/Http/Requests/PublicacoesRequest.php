<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Exists;

class PublicacoesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //criar validaçoes de permissoes de user, qual pode alterar / salvar e afins e aqui.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'NOME' => 'required',
            'DESCRICAO' => 'required',
            'DATAHORA' => 'required',
            'STATUS' => 'required|integer',
            'IDCATEGORIA' => 'required|integer',
            'IDBLOCO' => 'required|integer',
            'IDUSUARIO' => 'required|integer',
            //'imagem'    => 'required',
        ];
    }

    public function messages(): array
    {
        return [
        'NOME.required'             => 'O NOME da publicação é obrigatório',
        'DESCRICAO.required'        => 'A DESCRICAO da publicação é obrigatória',
        'DATAHORA.required'         => 'A DATAHORA da publicação é obrigatório',
        'STATUS.required'           => 'Status obrigatorio',
        'IDCATEGORIA.required'      => 'A CATEGORIA da publicação é obrigatória',
        'IDBLOCO.required'          => 'O BLOCO da publicação é obrigatória',
        'IDUSUARIO.required'        => 'Erro USUÁRIO logado perdeu a comunicação! Relogue.',
        //'imagem.required'           => 'Selecione uma imagem',
        ];
    }

}
