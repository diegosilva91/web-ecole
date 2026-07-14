<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class AuthenticateAdmin extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        if ($this->checkAuth()) {
            if (Auth::user()->hasRole('admin') && config('app.env') != 'production') {
                return $next($request);
            }
        }
        die('Hola!');
    }

    private function checkAuth(): bool
    {
        return Auth::check() || Auth::guard('api')->check();
    }
}
