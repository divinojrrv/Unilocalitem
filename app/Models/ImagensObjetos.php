<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagensObjetos extends Model
{
    use HasFactory;

    public $fillable = ['idimagem', 'idobjeto', 'tipo'];
}
