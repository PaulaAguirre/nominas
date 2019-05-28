<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
        //
    }

}
