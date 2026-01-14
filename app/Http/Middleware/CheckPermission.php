<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    /**
     * handle:
     * - Si un paramètre est fourni (ex: 'posts.create'), on vérifie cette permission.
     * - Si pas de param => on tente d'utiliser le nom de la route courante ($request->route()->getName()).
     */
    public function handle(Request $request, Closure $next, $permission = null)
    {
        $user = $request->user();

        // Si pas d'utilisateur connecté -> 401
        if (!$user) {
            abort(401, 'Non authentifié.');
        }

        // Permission recherchée
        $permissionToCheck = $permission ?: $request->route()->getName();

        if (!$permissionToCheck) {
            // Pas de permission indiquée et route sans nom -> bloquer par défaut
            abort(403, 'Permission non spécifiée pour cette route.');
        }

        if ($user->hasPermission($permissionToCheck) || $user->hasRole('super-admin')) {
            return $next($request);
        }

        abort(403, 'Accès refusé.');
    }
}
