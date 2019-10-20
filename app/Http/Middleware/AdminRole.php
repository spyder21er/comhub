<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminRole
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
        $userRole = Auth::user()->role->id;

        // if the user is not admin or super admin redirect to home
        if($userRole !== 2)
            return redirect('/');

        return $next($request);
    }
}
