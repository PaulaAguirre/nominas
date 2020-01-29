<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NominaIndirecta extends Model
{
    protected $table = 'nomina_indirecta';
    protected $primaryKey = "id";

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
}
