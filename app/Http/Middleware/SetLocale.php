<?php 
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        // Get the language from the request or session
        $locale = $request->get('lang', Session::get('locale', 'en'));
        
        // Set the application locale
        App::setLocale($locale);
           // Set text direction based on the language
           $direction = in_array($locale, ['fa', 'ps']) ? 'rtl' : 'ltr';
           Session::put('direction', $direction);
        // Store the locale in the session
        Session::put('locale', $locale);

        return $next($request);
    }
}
