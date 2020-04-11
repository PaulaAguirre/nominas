<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonaDirectaRPL extends Model
{
    protected $table = 'personas_directa_rpl';
    protected $primaryKey = "id_persona";

    protected $fillable = [ //asigna los campos de la tabla de BD
        'ch',
        'id_persona_anterior',
        'documento_persona',
        'fecha_ingreso',
        'nombre',
        'id_representante_jefe',
        'cargo',
        'id_zona',
        'id_zona_nuevo',
        'cargo_go',
        'activo',
        'agrupacion',
        'agrupacion_anterior',
        'estado_cambio',
        'motivo_rechazo',
        'regularizacion_cambio',
        'staff',
        'id_consideracion',
        'detalles_consideracion',
        'id_responsable_cambio'

    ];


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
