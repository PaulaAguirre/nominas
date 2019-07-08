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
        'aprobacion',
        'id_cosideracion',
        'detalles_consideracion'

    ];

    public function personaDirecta ()
    {
        return $this->belongsTo('App\PersonaDirecta', 'id_persona_directa');
    }

    public function consideracion ()
    {
        return $this->belongsTo('App\Consideracion');
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
       // $mes_nomina = NominaDirecta::all()->last()->mes;
        $mes_nomina = '201908';
        if($mes)
        {
            $query->where('mes', $mes);
        }

        $query->where('mes', $mes_nomina);

    }

    /** @var $query \Illuminate\Database\Query\Builder */
    public function scopeRepresentante ($query, $id_persona)
    {
        if($id_persona)
        {
            $query->where('id_nomina', $id_persona)->first();
        }

    }

}
