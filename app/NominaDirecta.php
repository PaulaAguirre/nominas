<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class NominaDirecta extends Model
{
    protected $table = 'nomina_directa';
    protected $primaryKey = "id_nomina";

    protected $fillable = [
        'id_persona_directa',
        'mes',
        'persona_mes',
        'estado_nomina',
        'motivo_rechazo',
        'id_cosideracion',
        'detalles_consideracion',
        'estado_consideracion',
        'motivo_rechazo_consideracion',
        'activo',
        'agrupacion',
        'motivo_rechazo',
        'regularizacion_nomina',
        'regularizacion_consideracion',
        'motivo_inactivacion',
        'detalles_inactivacion',
        'estado_inactivacion',
        'regularizacion_inactivacion',
        'comentario_consideracion'

    ];

    public function personaDirecta ()
    {
        return $this->belongsTo('App\PersonaDirecta', 'id_persona_directa');
    }

    public function consideracion ()
    {
        return $this->belongsTo('App\Consideracion', 'id_consideracion');
    }

    /** @var $query \Illuminate\Database\Query\Builder */
    public function scopeUltimaNomina ($query, $mes)
    {
        if (trim($mes)){
            $query->where('mes', $mes);
        }
    }

    /** @var $query \Illuminate\Database\Query\Builder */
    public function scopeMes($query, $mes)
    {
        if($mes)
        {
            $query->where('mes', $mes);
        }
        else
        {
            //$mes = Carbon::now()->addMonth()->format ('Ym');
            $mes = Carbon::now()->format ('Ym');
            $query->where('mes', $mes);
        }


    }

    /** @var $query \Illuminate\Database\Query\Builder */
    public function scopeRepresentanteDir ($query, $id_persona)
    {
        if($id_persona)
        {
            $query->where('id_persona_directa', $id_persona);
        }

    }
    /** @var $query \Illuminate\Database\Query\Builder */
    public function scopeZonadirecta($query, $id_zona, $id_jefe)
    {
        if ($id_zona and $id_jefe)
        {
            $query
                ->join('personas_directa', 'personas_directa.id_persona', '=', 'nomina_directa.id_persona_directa')
                //->where('id_zona', '=', $id_zona)
                //->where('id_representante_jefe', '=', $id_jefe)
                //no olvidar el mes
            ;
        }
        if ($id_zona and !$id_jefe)
        {
            $query
                ->join('personas_directa', 'personas_directa.id_persona', '=', 'nomina_directa.id_persona_directa')
                ->where('id_zona', '=', $id_zona)
               ;
        }
    }

    /** @var $query \Illuminate\Database\Query\Builder */
    public function scopeJefesDirecta($query, $id_jefe)
    {
        if ($id_jefe)
        {
            $query
                ->join('personas_directa', 'personas_directa.id_persona', '=', 'nomina_directa.id_persona_directa')
                ->where('id_representante_jefe', '=', $id_jefe)
                //no olvidar el mes
            ;
        }

    }
    public function scopeEstado($query, $estado)
    {
        if ($estado)
        {
            $query
                ->where('estado_nomina', '=', $estado)
                //no olvidar el mes
            ;
        }

    }
    /** @var $query \Illuminate\Database\Query\Builder */
    public function scopeConsideracion ($query, $id_consideracion)
    {
        if($id_consideracion)
        {
            $query->where('id_consideracion', $id_consideracion);
        }

    }

}
