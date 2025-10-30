<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Maneja la verificación de autenticación.
     */
    public function handle(Request $request, Closure $next)
    {
        // Si ya está autenticado, deja pasar.
        if (Auth::check()) {
            return $next($request);
        }

        // Guardamos la URL original solo para peticiones GET (para redirect()->intended).
        if ($request->isMethod('get')) {
            $request->session()->put('url.intended', $request->fullUrl());
        }

        // Si es petición AJAX/JSON devolvemos JSON 401.
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        // Para peticiones web: redirige al login (ruta con nombre 'login.index').
        return redirect()->route('login.index')
            ->withErrors(['auth' => 'Debes iniciar sesión para acceder a esa página ✌︎︎.']);
    }
}
