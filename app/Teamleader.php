<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teamleader extends Model
{
    protected $table = 'teamleaders';
    protected $primaryKey = 'id';

    public function tiendas ()
    {
        return $this->belongsToMany('App\Tienda');
    }

    public function clasificacion()
    {
        return $this->belongsTo('App\ClasificacionRetencion', 'clasificacion_id');
    }

    public function scopeTl($query, $teamleader_id)
    {
        if($teamleader_id)
        {
            $query->where('id', $teamleader_id);
        }
    }

    public function scopeTienda ($query, $tienda_id)
    {
        if ($tienda_id)
        {
            $query->whereHas('tiendas', function ($q1) use ($tienda_id)
            {
               $q1->where('tienda_id', $tienda_id);
            });
        }
    }

}
