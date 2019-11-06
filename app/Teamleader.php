<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teamleader extends Model
{
    protected $table = 'teamleaders';
    protected $primaryKey = 'id';

    public function tiendas ()
    {
        return $this->belongsToMany('App\Tienda');
    }

}
