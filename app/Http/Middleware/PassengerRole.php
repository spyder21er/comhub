<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class PassengerRole
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

        // if the user is not passenger or super admin redirect to home
        if($userRole !== 4)
            return redirect('/');

        return $next($request);
    }
}
