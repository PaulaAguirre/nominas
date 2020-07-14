<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TLretencion extends Model
{
    protected $table = 'tls_retencion';
    protected $primaryKey = "id";

    public function clasificacionRetencion()
    {
        return $this->belongsTo('App\ClasificacionRetencion', 'clasificacion_retencion_id');
    }
}
