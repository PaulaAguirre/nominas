<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NominaDirectaRPL extends Model
{
    protected $table = 'nomina_directa_rpl';
    protected $primaryKey = "id_nomina";

    public function personaDirecta ()
    {
        return $this->belongsTo('App\PersonaDirectaRPL', 'id_persona_directa');
    }

    public function consideracion ()
    {
        return $this->belongsTo('App\Consideracion', 'id_consideracion');
    }

    public function archivos ()
    {
        return $this->hasMany('App\ArchivoDirectaRPL', 'nomina_directa_id');
    }

    public function scopeZonasZonales($query, array $zonas)
    {
        return
            $query->whereHas('personaDirecta', function ($q1) use ($zonas)
            {
                $q1->whereIn('id_zona', $zonas)->where('cargo', '=', 'representante');
            });
    }

    public function scopeJefe($query, $jefe_id)
    {
        if ($jefe_id)
        {
            return $query->whereHas('personaDirecta', function ($q1) use ($jefe_id)
            {
                $q1->where('id_representante_jefe', '=', $jefe_id);
            }
            );
        }
    }

    public function scopeZona ($query, $zona_id)
    {
        if ($zona_id)
        {
            return $query->whereHas('personaDirecta', function ($q1) use ($zona_id)
            {
                $q1->where('id_zona', $zona_id);
            });
        }
    }

    public function scopeRepresentante($query, $representante_id, $mes)
    {
        if ($representante_id)
        {
            return $query->where('id_persona_directa', $representante_id)
                ->where('mes', $mes);
        }
    }

    public function scopeConsideracion ($query, $consideracion_id)
    {
        if ($consideracion_id)
        {
            return $query->where('id_consideracion', $consideracion_id);
        }
    }

    public function scopeEstadoConsideracion ($query, $estado)
    {
        if($estado)
        {
            return $query->where('estado_consideracion', $estado);
        }
    }

    public function scopeEstadoInactivacion ($query, $estado)
    {
        if($estado)
        {
            return $query->where('estado_inactivacion', $estado);
        }
    }


}
