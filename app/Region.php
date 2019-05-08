<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'regiones';
    protected $primaryKey = "id_region";

    public function  zonas ()
    {
        return $this->hasMany('App\Zona', 'id_region');
    }

}
