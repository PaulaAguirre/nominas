<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class PorcentajeDirecta extends Model
{
    protected $table = 'porcentajes_directa';
    protected $primaryKey = "id";

    /**
     * @param array $porc
     * @return Builder
     * @var $query Builder
     */
    public function scopeConsideraciones ($query, array $porc)
    {
        return
        $query->whereNotIn('nombre', $porc);
    }

    public function scopeInactivaciones ($query, array $porc)
    {
        return $query->whereIn('nombre', $porc);
    }

}
