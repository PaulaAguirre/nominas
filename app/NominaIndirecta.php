<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NominaIndirecta extends Model
{
    protected $table = 'nomina_indirecta';
    protected $primaryKey = "id";

    protected $fillable = [
        'id_asesor', 'mes', 'asesor_mes', 'id_consideracion', 'detalles_consideracion', 'estado_consideracion',
        'motivo_inactivacion', 'detalles_inactivacion', 'estado_inactivacion', 'comentarios_inactivacion', 'regularizacion_consideracion',
        'regularizacion_inactivacion', 'fecha_aprobacion_consideracion', 'fecha_aprobacion_inactivacion', 'porcentaje_objetivo'
    ];

    public function impulsador()
    {
        return $this->belongsTo('App\Impulsador');
    }

    public function consideracion()
    {
        return $this->belongsTo('App\Consideracion');
    }

    public function scopeImpulsadorInd($query, $impulsador_id)
    {
        if ($impulsador_id) {
            return $query->where('impulsador_id', $impulsador_id);
        }
    }

    public function scopeCoordinador($query, $coordinador_id)
    {
        if ($coordinador_id) {
            return $query->whereHas('impulsador', function ($q1) use ($coordinador_id) {
                $q1->where('coordinador_id', $coordinador_id);
            });
        }
    }

    public function scopeActivo($query, $activo)
    {
        if ($activo) {
            $query->where('estado_inactivacion', $activo);
        }

    }

    public function scopeZona($query, $zona_id)
    {
        if ($zona_id)
        {
            return
            $query->whereHas('impulsador', function ($q1) use ($zona_id)
            {
                $q1->where('zona_id', $zona_id);
            });
        }
    }

    public function scopeMes($query, $mes)
    {
        if($mes)
        {
            return $query->where('mes', $mes);
        }

    }

    public function scopeZonas ($query, array $zonas)
    {
        return
        $query->whereHas('impulsador', function ($q1) use ($zonas)
        {
            $q1->whereIn('zona_id', $zonas);
        });

    }

    public function archivos ()
    {
        return $this->hasMany('App\ArchivoIndirecta', 'nomina_indirecta_id');
    }

    public function scopeConsideracion($query, $id_consideracion)
    {
        if ($id_consideracion)
        {
            $query->where('consideracion_id', $id_consideracion);
        }

    }
    public function scopeEstadoConsideracion($query, $estado)
    {
        if ($estado)
        {
            $query->where('estado_consideracion', '=', $estado);
        }
    }

    public function scopeClasificacion ($query, $clasificacion_id)
    {
        if ($clasificacion_id)
        {
            $query->whereHas('impulsador', function ($q1) use ($clasificacion_id)
            {
                $q1->where('clasificacion_id', '=', $clasificacion_id);
            });
        }
    }

    public function scopeNoPdas ($query)
    {
        $query->whereHas('impulsador', function ($q1)
        {
            $q1->where('clasificacion_id', '<>', 2);
        });
    }

}
