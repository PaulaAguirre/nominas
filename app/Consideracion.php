<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consideracion extends Model
{
    protected $table = 'consideraciones';
    protected $primaryKey = "id";

    protected $fillable = [
        'nombre',
        'descripcion',
    ];
}
