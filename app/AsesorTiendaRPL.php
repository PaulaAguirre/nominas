<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AsesorTiendaRPL extends Model
{
    protected $table = 'asesores_tienda_rpl';
    protected $primaryKey = "id";

    protected $fillable = [
        'id_teamleader', 'id_anterior_teamleader', 'ch', 'documento', 'nombre', 'cargo_go', 'staff'
    ];

    public function teamleader()
    {
        return $this->belongsTo('App\Teamleader', 'id_teamleader');
    }

    public function tienda()
    {
        return $this->belongsTo('App\Tienda', 'id_tienda');
    }

    /** @var $query \Illuminate\Database\Query\Builder */
    public function scopeAsesor($query, $asesor_id)
    {
        if ($asesor_id) {
            $query->where('id', $asesor_id);

        }
    }

    public function zonaTienda($asesor_id)
    {
        if ($asesor_id) {
            return AsesorTiendaRPL::findOrFail($asesor_id)->tienda->zona;
        }
    }

    public function scopeZona ($query, $zona_id)
    {
        if ($zona_id)
        {
            return  $query->whereHas('tienda', function ($q) use ($zona_id)
            {
                $q->where('zona_id', '=', $zona_id);
            });
        }
    }

    public function scopeTienda($query, $tienda_id)
    {
        if($tienda_id)
        {
            return $query->where('id_tienda', $tienda_id);
        }
    }

    public function scopeTeamleader($query, $teamleader_id)
    {
        if ($teamleader_id)
        {
            $query->where('id_teamleader', $teamleader_id);
        }
    }

    public function scopeEstado($query, $estado)
    {
        if($estado)
        {
            $query->where('activo','=', $estado);
        }

    }

    public function supervisor()
    {
        return $this->belongsTo('App\SupervisorGuiaTigo', 'supervisor_guiatigo_id');
    }

    public function supervisorRetencion()
    {
        return $this->belongsTo('App\SupervisorRerencion', 'supervisor_retencion_id');
    }

}
