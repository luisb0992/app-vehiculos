<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SuperAdminOrRecorderRolMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // obtener el usuario
        $user = $request->user();

        // verificar si el usuario tiene el rol de superadmin
        if ($user->isSuperAdmin() || $user->isRecorder()) {
            return $next($request);
        }

        // redireccion a la página anterior
        return redirect()->back()->with('error', 'No tienes permiso para acceder a este contenido');
    }
}
