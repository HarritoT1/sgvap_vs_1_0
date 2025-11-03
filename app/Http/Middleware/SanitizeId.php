<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SanitizeId
{
    /**
     * Maneja la sanitización del parámetro 'id' en la request.
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->has('id')) {
            // Ejemplo: "ABC123 - EMPRESA XYZ" → "ABC123"
            $cleanId = trim(explode('→', $request->input('id'))[0]);
            $request->merge(['id' => $cleanId]);
        }

        return $next($request);
    }
}
