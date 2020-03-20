<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArchivoDirectaRPL extends Model
{

    protected $table = 'archivos_directa_rpl';
    protected $primaryKey = "id";

    protected $fillable =
        [
            'tipo',
            'nombre',
            'nomina_directa_id'
        ];

    public function nomina_directa()
    {
        return $this->belongsTo('App\NominaDirectaRPL','nomina_directa_id');
    }
}
