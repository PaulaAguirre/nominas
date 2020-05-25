<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArchivoIndirecta extends Model
{
    protected $table = 'archivos_indirecta';
    protected $primaryKey = "id";

    protected $fillable =
        [
            'tipo',
            'nombre',
            'nomina_indirecta_id'
        ];

    public function nomina_indirecta()
    {
        return $this->belongsTo('App\NominaIndirecta');
    }

}
