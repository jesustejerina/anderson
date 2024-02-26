<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }

    // Esto lo agregué para personalizar el mensaje cuando intentan ingresar a una ruta no autenticado.
    protected function unauthenticated($request, array $guards) : Json
    {
        abort(response()->json([
            'status' => 'ERROR',
            'message' => 'No autorizado',], 401));
    }
}
