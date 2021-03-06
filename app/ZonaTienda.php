<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZonaTienda extends Model
{
    protected $table = 'zonas_tiendas';
    protected $primaryKey = "id";

    public function region()
    {
        return $this->belongsTo('App\Region', 'id_region');
    }

    public function familiazona ()
    {
        return $this->belongsTo('App\FamiliaZona', 'id_familiazona');
    }

}
