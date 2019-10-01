<?php

namespace App\Http\Middleware;

use Closure;

class DriverRole
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
        // if the user is not driver redirect to home
        if (Auth::user()->role->id !== 3)
            return redirect('/');

        return $next($request);
    }
}
