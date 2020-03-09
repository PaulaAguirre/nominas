<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pdv extends Model
{

    protected $table = 'pdvs';
    protected $primaryKey = "id";

    protected $fillable = [
        'codigo',
        'circuito_id',
    ];

    public function circuito()
    {
        return $this->belongsTo('App\Circuito');
    }
}
