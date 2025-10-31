<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SanitizeId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->has('id')) {
            // Ejemplo: "ABC123 - EMPRESA XYZ" → "ABC123"
            $cleanId = trim(explode('-', $request->input('id'))[0]);
            $request->merge(['id' => $cleanId]);
        }

        return $next($request);
    }
}
