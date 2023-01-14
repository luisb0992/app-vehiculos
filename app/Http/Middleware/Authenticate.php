<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login');
        }
    }

    public function handle(Request $request, Closure $next, ...$guards)
    {
        // verificar si esta logueado
        if (!auth()->check()) {
            return redirect('/')->with('error', 'No puedes ingresar al sistema, debes iniciar sesión.');
        }

        // verificar si esta logueado e inactivo
        if (auth()->check() && auth()->user()->inactive()) {
            $this->logout($request);
            return redirect('/')->with('error', 'No puedes ingresar al sistema, tu estatus es inactivo.');;
        }

        return $next($request);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
    }
}
