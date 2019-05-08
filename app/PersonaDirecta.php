<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonaDirecta extends Model
{
    protected $table = 'roles';
    protected $primaryKey = "id";

    protected $fillable = [ //asigna los campos de la tabla de BD
        'ch',
        'documento_persona',
        'nombre',
        'id_jefe',
        'cargo',
        'id_region',
        'id_zona',
        'cargo_go',
        'activo',
    ];

    public function region ()
    {
        return $this->belongsTo('App\Region', 'id_region');
    }

    public function zona ()
    {
        return $this->belongsTo('App\Zona', 'id_zona');
    }

}
