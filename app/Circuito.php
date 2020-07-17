<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Circuito extends Model
{
    protected $table = 'circuitos';
    protected $primaryKey = "id";

    protected $fillable = [
        'codigo',
        'zona_id',
        'coordinador_id',
        'auditor_id'
    ];

    public function zona ()
    {
        return $this->belongsTo('App\ZonaIndirecta');
    }

    public function pdvs ()
    {
        return $this->hasMany('App\Pdv');
    }

    public function coordinador ()
    {
        return $this->belongsTo('App\Coordinador');
    }

    public function auditor()
    {
        return $this->belongsTo('App\Impulsador', 'auditor_id');
    }

    public function scopeBuscarAuditor($query ,$auditor_id)
    {
        if ($auditor_id)
        {
            return $query->where('auditor_id', '=', $auditor_id);
        }
    }

    public function scopeCircuito($query, $circuito_id)
    {
        if ($circuito_id)
        {
            return $query->where('id', '=', $circuito_id);
        }
    }

    public function scopeBuscarCoordinador($query, $coordinador_id)
    {
        if ($coordinador_id)
        {
            return $query->where('coordinador_id', '=', $coordinador_id);
        }
    }
}
