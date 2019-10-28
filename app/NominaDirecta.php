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
        'comentario_inactivacion',
        'fecha_aprobacion_consideracion',
        'fecha_aprobacion_inactivacion',
        'porcentaje_objetivo'

    ];

    public function personaDirecta ()
    {
        return $this->belongsTo('App\PersonaDirecta', 'id_persona_directa');
    }

    public function archivos()
    {
        return $this->hasMany('App\Archivo', 'id_nomina_directa');
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
    public function scopeEstadoConsideracion ($query, $estado)
    {
        if (trim($estado)){
            $query->where('estado_consideracion', $estado);
        }
    }

    /** @var $query \Illuminate\Database\Query\Builder */
    public function scopeEstadoInactivacion ($query, $estado)
    {
        if (trim($estado)){
            $query->where('estado_inactivacion', $estado);
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
            $fecha1 = new Carbon('first day of this month');
            $fecha2 = (new Carbon('first day of this month'))->addDays(20);
            $mes = Carbon::now();
            if ($mes->between($fecha1, $fecha2))
            {
                $mes_format = $mes->format('Ym');
            }
            else
            {
                $mes_format = $mes->addMonth(1)->format('Ym');
            }

            $query->where('mes', $mes_format);

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
            //
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

    /** @var $query \Illuminate\Database\Query\Builder */
    public function scopeInactivo ($query, $activo)
    {
        $mes = Carbon::now()->format('Ym');
        if($activo)
        {
            if ($activo == 'activo')
            {
                $query->whereNull('estado_inactivacion')
                ->where('mes', '=', $mes);

            }
            else{
                $query->where('estado_inactivacion', $activo)
                    ->where('mes', '=', $mes);
            }

        }

    }





}
