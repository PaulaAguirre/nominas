<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function zonas()
    {
        return $this->belongsToMany('App\Zona', 'user_zona','user_id', 'zona_id');
    }

    public function canales ()
    {
        return $this->belongsToMany('App\Canal');
    }

    public function zonasTienda()
    {
        return $this->belongsToMany('App\ZonaTienda', 'user_zonatienda');
    }


    public function roles ()
    {
        return $this->belongsToMany('App\Role', 'user_role')->withTimestamps();
    }

    public function hasRoles (array $roles)
    {
        foreach ($roles as $role)
        {
            foreach ($this->roles as $userRole)
            {
                if ($userRole->nombre == $role)
                {
                    return true;
                }
            }
        }
        return false;
    }

    public function hasZonas (array $zonas)
    {
        foreach ($zonas as $zona)
        {
            foreach ($this->zonas as $userZona)
            {
                if ($userZona->zona == $zona)
                {
                    return true;
                }
            }
        }
        return false;
    }

    public function hasCanales (array $canales)
    {
        foreach ($canales as $canal)
        {
            foreach ($this->canales as $userCanal)
            {
                if ($userCanal->canal == $canal)
                {
                    return true;
                }
            }
        }
        return false;
    }

    public function zonasIndirecta()
    {
        return $this->hasMany('App\ZonasIndirecta', 'user_zona_indirecta');
    }

}
