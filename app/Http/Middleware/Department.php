<?php 

namespace App\Http\Middleware;
use Auth;
use Closure;

class Department {

    public function handle($request, Closure $next)
    {

        if ( Auth::check() && Auth::user()->type == 2 )
        {
            return $next($request);
        }

        return redirect('home');

    }

}