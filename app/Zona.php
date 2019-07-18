<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{
    protected $table = 'zonas';
    protected $primaryKey = "id";


    public function region()
    {
        return $this->belongsTo('App\Region', 'id_region');
    }
}
