<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionTimeout
{
    /**
     * Maneja la verificación de inactividad.
     * Usa env('SESSION_INACTIVITY') en minutos.
     */
    public function handle(Request $request, Closure $next)
    {
        // Solo aplica si hay sesión iniciada (o si quieres aplicarlo siempre, ajusta).
        // Necesitamos tener session disponible (poner middleware después de StartSession).
        $inactivityMinutes = (int) config('session.inactivity', env('SESSION_INACTIVITY', 15));

        // Obtener timestamp de última actividad guardado en la sesión.
        $last = $request->session()->get('last_activity');

        $now = now()->timestamp;

        if ($last) {
            $elapsed = ($now - (int)$last) / 60; // minutos.

            if ($elapsed > $inactivityMinutes) {
                // timeout por inactividad: cerrar sesión y devolver respuesta.
                if (Auth::check()) {
                    Auth::logout();
                }

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                // Si es petición AJAX/JSON devolvemos 401, si es web redirect a login.
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Sesión expirada por inactividad.'], 401);
                }

                return redirect()->route('login.index')->withErrors(['session' => 'Sesión expirada por inactividad.']);
            }
        }

        // Actualiza la última actividad en cada request.
        $request->session()->put('last_activity', $now);

        return $next($request);
    }
}
