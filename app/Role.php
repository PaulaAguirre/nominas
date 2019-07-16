<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $primaryKey = "id";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     *
     */
    protected $fillable = [
        'nombre', 'descripcion'
    ];

    public function users ()
    {
        return $this->belongsToMany('App\User')->withTimestamps();
    }
}
