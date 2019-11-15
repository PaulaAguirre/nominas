<?php

namespace App\Http\Middleware;

use Closure;

class CheckCanal
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
        $canales = array_slice(func_get_args(),2);
        if (auth()->user()->hasCanales($canales))
        {
            //dd('si');
            return $next($request);
        }
        return redirect()->back();
    }
}
