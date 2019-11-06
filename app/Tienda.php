<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tienda extends Model
{
    protected $table = 'tiendas';
    protected $primaryKey = "id";

    public function zona()
    {
        return $this->belongsTo('App\ZonaTienda', 'zona_id');
    }

    public function jefetienda()
    {
        return $this->belongsTo('App\JefeTienda', 'jefe_tienda_id');
    }

    public function teamleaders ()
    {
        return $this->belongsToMany('App\Teamleader');
    }
}
