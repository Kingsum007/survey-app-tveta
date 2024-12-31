<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAccountStatus
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        // Ensure the user is logged in
        if (!$user) {
            return redirect('/login')->with('error', 'Please log in to access this page.');
        }

        // Check if the account is active
        if (!$user->is_active) {
            auth()->logout();
            return redirect('/login')->with('error', 'This account is no longer active.');
        }

        return $next($request);
    }
}
