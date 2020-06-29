<?php

namespace App\Http\Middleware;

use Closure;
use App;
use Auth;
use URL;

class Locale
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
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasMetadata('locale')) {
                $locale = $user->getMetadata('locale');
            } else {
                $locale = config()->get('app.locale');
                $user->saveMetadata('locale', $locale);
            }
        } elseif ($request->has('locale')) {
            $locale = $request->locale;
            URL::defaults(['locale' => $locale]);
        } else {
            $locale = config()->get('app.locale');
            URL::defaults(['locale' => $locale]);
        }
        
        App::setLocale($locale);

        return $next($request);
    }
}
