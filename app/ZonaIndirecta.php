<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZonaIndirecta extends Model
{
    protected $table = 'zonas_indirecta';
    protected $primaryKey = "id";

    public function region()
    {
        return $this->belongsTo('App\Region', 'region_id');
    }

    public function familiazona ()
    {
        return $this->belongsTo('App\FamiliaZona', 'familia_zona_id');
    }
}
