<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tienda extends Model
{
    protected $table = 'tiendas';
    protected $primaryKey = "id";

    public function zona ()
    {
        $this->belongsTo('App\ZonaTienda', 'zona_id');
    }
}
