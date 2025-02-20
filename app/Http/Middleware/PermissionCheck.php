<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PermissionCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,string $permission = null): Response
    {
  
        // Disable middleware in local environment
        if (app()->environment('local')) {
            return $next($request);
        }

        
        $user = Auth::user();
        if (!$user || !$user->can($permission)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
