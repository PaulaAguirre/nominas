<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use function foo\func;

class NominaTienda extends Model
{
    protected $table = 'nominas_tienda';
    protected $primaryKey = "id";

    protected $fillable = [
      'id_asesor', 'mes', 'asesor_mes', 'id_consideracion', 'detalles_consideracion', 'estado_consideracion',
        'motivo_inactivacion', 'detalles_inactivacion', 'estado_inactivacion', 'comentarios_inactivacion', 'regularizacion_consideracion',
        'regularizacion_inactivacion', 'fecha_aprobacion_consideracion', 'fecha_aprobacion_inactivacion', 'porcentaje_objetivo'
    ];

    public function asesor ()
    {
        return $this->belongsTo('App\AsesorTienda', 'id_asesor');
    }

    public function consideracion ()
    {
        return $this->belongsTo('App\Consideracion', 'id_consideracion');
    }

    public function archivos ()
    {
        return $this->hasMany('App\ArchivoTienda', 'nomina_tienda_id');
    }

    /**
     * @param $query
     * @param $zona_id
     * @return
     */
    public function scopeZona ($query, $zona_id)
    {
        if ($zona_id)
        {
            return
            $query->whereHas('asesor', function ($q1) use ($zona_id)
            {
                $q1->whereHas('tienda', function ($q2) use ($zona_id)
                {
                    $q2->where('zona_id', '=', $zona_id);
                });
            }
            );
        }
    }

    public function scopeTienda($query, $tienda_id)
    {
        if ($tienda_id)
        {
            return
            $query->whereHas('asesor', function ($q1) use ($tienda_id)
            {
                $q1->where('id_tienda', $tienda_id);
            });
        }
    }

    public function scopeTeamleader($query, $tl_id)
    {
        if ($tl_id)
        {
            return
            $query->whereHas('asesor', function ($q1) use ($tl_id)
            {
               $q1->where('id_teamleader', $tl_id);
            });
        }
    }

    public function scopeTiendas($query, array $zonas)
    {
        return
        $query->whereHas('asesor', function ($q1) use ($zonas)
        {
           $q1->whereHas('tienda', function ($q2) use ($zonas)
           {
               $q2->whereIn('zona_id', $zonas);
           });
        });
    }

    public function scopeActivo($query, $activo)
    {
        if ($activo) {
            $query->where('estado_inactivacion', $activo);
        }
    }

    public function scopeAsesor($query, $asesor_id)
    {
        if ($asesor_id)
        {
            $query->where('id_asesor', '=', $asesor_id);
        }
    }

    public function scopeMes($query, $mes_nomina)
    {
        $query->where('mes', '=', $mes_nomina);
    }

    public function scopeConsideracion($query, $id_consideracion)
    {
        if ($id_consideracion)
        {
            $query->where('id_consideracion', $id_consideracion);
        }

    }

    public function scopeEstadoInactivacion($query, $estado)
    {
        if ($estado)
        {
            $query->where('estado_inactivacion', '=', $estado);
        }
    }

    public function scopeEstadoConsideracion($query, $estado)
    {
        if ($estado)
        {
            $query->where('estado_consideracion', '=', $estado);
        }
    }

}
