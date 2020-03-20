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

}
