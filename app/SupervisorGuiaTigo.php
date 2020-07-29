<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupervisorGuiaTigo extends Model
{
    protected $table = 'supervisor_guiatigo';
    protected $primaryKey = "id";

    protected $fillable = [
        'ch', 'nombre', 'documento', 'tipo_supervisor'
    ];

    public function scopeSupervisor($query, $supervisor_id)
    {
        if($supervisor_id)
        {
            return $query->where('id', $supervisor_id);
        }
    }
}
