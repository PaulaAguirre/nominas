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
        'coordinador_id'
    ];

    public function zona ()
    {
        return $this->belongsTo('App\ZonaIndirecta');
    }

    public function pdvs ()
    {
        return $this->hasMany('App\Pdv');
    }
}
