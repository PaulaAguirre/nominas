<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class PersonaDirecta extends Model
{
    protected $table = 'personas_directa';
    protected $primaryKey = "id_persona";

    protected $fillable = [ //asigna los campos de la tabla de BD
        'ch',
        'documento_persona',
        'nombre',
        'id_representante_zonal',
        'id_representante_jefe',
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

    public function representanteZonal()
    {
        return $this->belongsTo('App\PersonaDirecta', 'id_representante_zonal');
    }

    public function representanteJefe ()
    {
        return $this->belongsTo('App\PersonaDirecta', 'id_representante_jefe');
    }

    public function representantes ()
    {
        return $this->hasMany('App\PersonaDirecta', 'id_representante_jefe');
    }

    /*** Scopes***/


    /** @var $query \Illuminate\Database\Query\Builder */
    public function scopeName ($query, $name)
    {
        if (trim($name))
        {
            $query->where ('nombre', 'like', '%'.$name.'%');

        }

    }

    /** @var $query \Illuminate\Database\Query\Builder */
    public function scopeRepresentantes ($query)
    {
        $query->where('')->get();
    }


}
