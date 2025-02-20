<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class admin_auth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Disable middleware in local environment
        if (app()->environment('local')) {
            return $next($request);
        }

        
        if(!(Auth::user())){
            return redirect('/');
        }
        if(Auth::user()->user_type == "user" ){
            return redirect('/');

        }
        return $next($request);
    }
}


