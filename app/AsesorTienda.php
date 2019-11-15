<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class AsesorTienda extends Model
{
    protected $table = 'asesores_tienda';
    protected $primaryKey = "id";

    protected $fillable = [
        'id_teamleader', 'id_anterior_teamleader', 'ch', 'documento', 'nombre', 'cargo_go', 'staff'
    ];

    public function teamleader()
    {
        return $this->belongsTo('App\Teamleader', 'id_teamleader');
    }

    public function tienda()
    {
        return $this->belongsTo('App\Tienda', 'id_tienda');
    }

    /** @var $query \Illuminate\Database\Query\Builder */
    public function scopeAsesor($query, $asesor_id)
    {
        if ($asesor_id) {
            $query->where('id', $asesor_id);

        }
    }

    public function zonaTienda($asesor_id)
    {
        if ($asesor_id) {
            return AsesorTienda::findOrFail($asesor_id)->tienda->zona;
        }
    }

    public function scopeZona ($query, $zona_id)
    {
        if ($zona_id)
        {
          return  $query->whereHas('tienda', function ($q) use ($zona_id)
            {
                $q->where('zona_id', '=', $zona_id);
            });
        }
    }

}
