<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\ActivityCustom;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = auth()->user();
        activity()->log('Inicio de sesión - '.date('Y-m-d H:i:s'))->tap(function(ActivityCustom $activity) {
            $activity->name = 'Usuario';
         });

        // superadmin
        if ($user->isSuperAdmin()) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        // registrador
        if ($user->isRecorder()) {
            return redirect()->intended(RouteServiceProvider::VEHICLE);
        }

        // si es usuario proveedor taller
        if ($user->isSupplier()) {
            return redirect()->intended(RouteServiceProvider::QUOTE);
        }

        // falta por definir el usuario para reportes ...
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        activity()->log('Salió del sistema - '.date('Y-m-d H:i:s'));
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
