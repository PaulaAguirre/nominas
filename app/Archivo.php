<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    protected $table = 'archivos';
    protected $primaryKey = "id";

    protected $fillable =
    [
        'tipo',
        'nombre',
        'id_nomina_directa'
    ];

    public function nomina_directa()
    {
        return $this->belongsTo('App\NominaDirecta','id_nomina_directa');
    }

}
