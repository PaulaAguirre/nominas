<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pdv extends Model
{

    protected $table = 'pdvss';
    protected $primaryKey = "id";

    protected $fillable = [
        'codigo',
        'circuito_id',
        'impulsador_id',
        'nombre'
    ];

    public function circuito()
    {
        return $this->belongsTo('App\Circuito');
    }

    public function impulsador ()
    {
        return $this->belongsTo('App\Impulsador');
    }

    public function scopeImpulsadorPDV($query, $impulsador_id)
    {
        if ($impulsador_id)
        {
            return $query->where('impulsador_id', '=', $impulsador_id);
        }
    }

    public function scopePdv ($query, $pdv_id)
    {
        if($pdv_id)
        {
            return $query->where('id', '=', $pdv_id);
        }
    }

    public function scopeBuscarCircuito($query, $circuito_id)
    {
        if ($circuito_id)
        {
            return $query->where('circuito_id', '=', $circuito_id);
        }
    }

    public function scopeBuscarCoordinador($query, $ccoordinador_id)
    {
        if ($ccoordinador_id)
        {
            $query->whereHas('circuito', function ($q1) use ($ccoordinador_id)
            {
                $q1->where('coordinador_id', '=', $ccoordinador_id);
            });
        }

    }
}
