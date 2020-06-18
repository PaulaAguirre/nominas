<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coordinador extends Model
{
    protected $table = 'coordinadores';
    protected $primaryKey = "id";

    public function zonas ()
    {
        return $this->belongsToMany('App\ZonaIndirecta', 'coordinador_zona');
    }

    public function circuitos ()
    {
        return $this->hasMany('App\Circuito');
    }

}
