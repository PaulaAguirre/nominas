<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClasificacionImpulsadores extends Model
{
    protected $table = 'clasificaciones_indirecta';
    protected $primaryKey = "id";

    protected $fillable = [
        'id',
        'nombre',
        'descripcion'
    ];
}
