<?php 

namespace App\Http\Middleware;
use Auth;
use Closure;

class User {

    public function handle($request, Closure $next)
    { 
        if ( Auth::check() && Auth::user()->type == 3 )
        {
            return $next($request);
        }

        return redirect('home');

    }

}