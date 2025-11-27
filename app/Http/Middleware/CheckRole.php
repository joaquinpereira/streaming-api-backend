<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Maneja una solicitud entrante.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Verificar si el usuario está autenticado
        if (! $request->user()) {
            return response()->json([
                'message' => 'No autenticado. Se requiere un token de acceso válido.'
            ], 401);
        }

        // 2. Verificar la Ability (Rol)
        // El método tokenCan() verifica si el token tiene la capacidad especificada.
        if (! $request->user()->tokenCan($role)) {
            // Si el token NO tiene la habilidad (rol) requerido, se deniega el acceso (403 Forbidden)
            return response()->json([
                'message' => 'Acceso denegado. Se requiere el rol: ' . strtoupper($role)
            ], 403);
        }

        // 3. Si el usuario está autenticado y tiene el rol, se permite la solicitud.
        return $next($request);
    }
}