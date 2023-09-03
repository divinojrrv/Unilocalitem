<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manifestacoes extends Model
{
    use HasFactory;

    // Define o nome da coluna da chave primária (caso não seja 'id')
    protected $primaryKey = 'ID';

    public $fillable = [

        'DATAHORA',
        'IDUSUARIO',
        'IDPUBLICACAO',
    ];
}
