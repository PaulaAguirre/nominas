<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArchivoTienda extends Model
{
    protected $table = 'archivos_tienda';
    protected $primaryKey = "id";

    protected $fillable =
        [
            'tipo',
            'nombre',
            'nomina_tienda_id'
        ];

    public function nomina_tienda()
    {
        return $this->belongsTo('App\NominaTienda','nomina_tienda_id');
    }

}
