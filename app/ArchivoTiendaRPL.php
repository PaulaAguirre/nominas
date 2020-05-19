<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArchivoTiendaRPL extends Model
{
    protected $table = 'archivos_directa_rpl';
    protected $primaryKey = "id";

    protected $fillable =
        [
            'tipo',
            'nombre',
            'nomina_tienda_id'
        ];

    public function nomina_tienda()
    {
        return $this->belongsTo('App\NominaTiendaRPL','nomina_tienda_id');
    }
}
