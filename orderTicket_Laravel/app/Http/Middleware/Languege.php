<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class Languege
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        App::setLocale(App::getLocale());
        return $next($request);
    }
}
