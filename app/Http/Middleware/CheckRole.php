<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $roles = array_slice(func_get_args(),2);

        foreach ($roles as $role)
        {
            if (auth()->user()->hasRoles($role))
            {
                return $next($request);
            }
        }



        return redirect('/nomina_directa');
    }
}
