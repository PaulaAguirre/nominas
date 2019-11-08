<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AsesorTienda extends Model
{
    protected $table = 'asesores_tienda';
    protected $primaryKey = "id";

    public function teamleader ()
    {
        return $this->belongsTo('App\Teamleader', 'id_teamleader');
    }

    public function tienda ()
    {
        return $this->belongsTo('App\Tienda', 'id_tienda');
    }

    /** @var $query \Illuminate\Database\Query\Builder */
    public function scopeAsesor($query,$asesor_id)
    {
        if ($asesor_id)
        {
            $query->where('id', $asesor_id);
        }
    }

    public function zona ($asesor_id)
    {
        if ($asesor_id)
        {
            return AsesorTienda::findOrFail($asesor_id)->tienda->zona;
        }
    }


}
