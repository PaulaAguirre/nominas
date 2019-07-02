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


    /** @var $query \Illuminate\Database\Query\Builder */
    public function scopeName ($query, $name)
    {
        if (trim($name))
        {
            $query->where ('nombre', 'like', '%'.$name.'%');

        }

    }

    /** @var $query \Illuminate\Database\Query\Builder */
    public function scopeJefe ($query, $id_jefe)
    {
        if (trim($id_jefe))
        {
         $query->where('id_representante_jefe',  $id_jefe);
        }
    }

    /** @var $query \Illuminate\Database\Query\Builder */
    public function scopeZonal($query, $id_zonal)
    {
        if (trim($id_zonal))
        {
            $query->where('id_representante_zonal', $id_zonal);
        }
    }

    public function scopeRepresentantesdir ($query, $id_representante)
    {
        if ($id_representante)
        {
            $query->where('cargo_go', '<>', 'NULL')
                ->where('id_persona', $id_representante);
        }

        $query->where('cargo_go', '<>', 'NULL');
    }


}
