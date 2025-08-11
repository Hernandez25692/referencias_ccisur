<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminOrInvitado
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (!$user) {
            abort(403, 'Acceso no autorizado');
        }

        // Si el usuario tiene cualquiera de estos roles, deja pasar
        if ($user->hasAnyRole(['SuperAdmin', 'Invitado'])) {
            return $next($request);
        }

        abort(403, 'Acceso no autorizado');
    }
}
