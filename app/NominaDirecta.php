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
        'consideraciones',

    ];

    public function personaDirecta ()
    {
        return $this->belongsTo('App\PersonaDirecta', 'id_persona_directa');
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
        $mes_nomina = NominaDirecta::all()->last()->mes;
        if($mes)
        {
            $query->where('mes', $mes);
        }

        $query->where('mes', $mes_nomina);

    }




}
