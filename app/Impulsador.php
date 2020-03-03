<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class Impulsador extends Model
{
    protected $table = 'impulsadores';
    protected $primaryKey = "id";

    protected $fillable =
        ['cooridnador_id', 'zona_id', 'ch', 'documento', 'nombre'];

    public function coordinador()
    {
        return $this->belongsTo('App\Coordinador');
    }

    public function zona()
    {
        return $this->belongsTo('App\ZonaIndirecta', 'zona_id');
    }

    public function clasificacion ()
    {
        return $this->belongsTo('App\ClasificacionImpulsadores', 'clasificacion_id');
    }

    /** @return Builder
     * @var $query Builder
     */
    public function scopeImpulsador($query, $impulsador_id)
    {
        if($impulsador_id)
        {
            return $query->where('id', '=', $impulsador_id);
        }
    }

    /** @return Builder
     * @var $query Builder
     */
    public function scopeCoordinadorInd($query, $coordinador_id)
    {
        if($coordinador_id)
        {
            return $query->where('coordinador_id', '=', $coordinador_id);
        }
    }

    /** @return Builder
     * @var $query Builder
     */
    public function scopeZonaInd($query, $zona_id)
    {
        if($zona_id)
        {
            return $query->where('zona_id', '=', $zona_id);
        }
    }

    /**
     * @param $query
     * @param $activo
     * @return
     */
    public function scopeActivo($query, $activo)
    {
        if($activo)
        {
           return $query->where('activo', '=', $activo);
        }
    }

}

