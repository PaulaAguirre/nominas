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
        'fecha_ingreso',
        'nombre',
        'id_representante_jefe',
        'cargo',
        'id_zona',
        'id_zona_nuevo',
        'cargo_go',
        'activo',
        'agrupacion',
        'estado_cambio',
        'motivo_rechazo',
        'regularizacion_cambio',
        'staff'

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

    public function representanteJefeNuevo ()
    {
        return $this->belongsTo('App\PersonaDirecta', 'id_representante_jefe_nuevo');
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


    public function scopeRepresentantesdir ($query, $id_representante)
    {
        if ($id_representante)
        {
            $query
                //->where('cargo', '=', 'representante')
                ->where('id_persona', $id_representante);
        }

       $query->where('cargo', '=', 'representante')
        ->where('activo', '=', 'activo');
    }

    /** @var $query \Illuminate\Database\Query\Builder */
    public function scopeZonaDir ($query, $id_zona)
    {
        if ($id_zona)
        {
            $query->where('id_zona',  $id_zona);
        }


    }





}
