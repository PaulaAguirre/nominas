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

    public function teamleaders()
    {
        return $this->belongsToMany('App\Teamleader')->withTimestamps();
    }

    public function scopeTienda($query, $tienda_id)
    {
        if ($tienda_id)
        {
             $query->where('id', '=', $tienda_id);
        }
    }

    public function scopeZonaTienda ($query, $zona_id)
    {
        if ($zona_id)
        {
             $query->where('zona_id','=', $zona_id);
        }
    }

}
