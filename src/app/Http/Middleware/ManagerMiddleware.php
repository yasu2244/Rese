<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ManagerMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->isManager()) {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}
