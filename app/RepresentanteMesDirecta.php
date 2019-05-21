<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RepresentanteMesDirecta extends Model
{
    protected $table = 'representantes_x_mes_directa';
    protected $primaryKey = "id";

    protected $fillable = [
        'id_representante',
        'año_mes',
        'id_representante_zonal',
        'id_representante_jefe',
    ];


}
