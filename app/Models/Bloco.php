<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bloco extends Model
{
    use HasFactory;

    protected $blocos = 'blocos';
    protected $factory = \Database\Factories\BlocoFactory::class;
}
