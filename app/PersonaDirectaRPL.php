<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonaDirectaRPL extends Model
{
    protected $table = 'personas_directa_rpl';
    protected $primaryKey = "id_persona";

    public function zona ()
    {
        return $this->belongsTo('App\Zona', 'id_zona');
    }

    public function zona_nuevo ()
    {
        return $this->belongsTo('App\Zona', 'id_zona_nuevo');
    }

    public function representanteJefe ()
    {
        return $this->belongsTo('App\PersonaDirecta', 'id_representante_jefe');
    }

    public function responsable_cambio ()
    {
        return $this->belongsTo('App\User', 'id_responsable_cambio');
    }


    public function jefeNuevo()
    {
        return $this->belongsTo('App\PersonaDirecta', 'id_representante_jefe_nuevo');
    }

    public function consideracion ()
    {
        return $this->belongsTo('App\Consideracion', 'id_consideracion ');
    }
}
