<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;
class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
       // Check if the user is authenticated and has an 'admin' role
       if (Auth::check() && Auth::user()->role === 'admin') {
        // Allow the request to proceed if the user is an admin
        return $next($request);
    }

    // Redirect to the main route if the user is not an admin
    return redirect('/');
}
    
}
