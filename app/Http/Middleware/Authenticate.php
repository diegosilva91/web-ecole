<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if ($request->expectsJson()) {
            return response()->json([ 'error' => 'Unauthorized', 'user_id' => Auth::id() ], 419);
        }
        return false;
    }

    public function handle($request, Closure $next, ...$guards)
    {
        if ($this->checkAuth()) {
            if (!Auth::user()->hasRole('admin')) {
                if (!empty($request->route('user_id'))) {
                    if (Auth::id() !== (int) $request->route('user_id')) {
                        return $this->redirectTo($request);
                    }
                }
                if (!empty($request->route('id'))) {
                    if (Auth::id() !== (int) $request->route('id')) {
                        return $this->redirectTo($request);
                    }
                }
            }
            return $next($request);
        }
        $this->authenticate($request, $guards);
        return $next($request);
    }

    private function checkAuth(): bool
    {
        return Auth::check() || Auth::guard('api')->check();
    }

    protected function authenticate($request, array $guards)
    {
        if (empty($guards)) {
            $guards = [ null ];
        }

        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                return $this->auth->shouldUse($guard);
            }
        }

        $this->unauthenticated($request, $guards);
    }
}
