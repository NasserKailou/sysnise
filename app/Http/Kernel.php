<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     */
    protected $middleware = [
        // Middleware global (pour toutes les requêtes)
        \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // Active le support pour les erreurs de validation dans les vues
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            // Exemple : limite à 60 requêtes par minute par utilisateur
            \Illuminate\Routing\Middleware\ThrottleRequests::class . ':api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * Ces middlewares peuvent être assignés individuellement à des routes.
     */
    protected $routeMiddleware = [
        // Authentification / Sécurité
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

        // Throttling / Signatures / Cache
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,

        // Liaison des modèles sur les routes
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,

        // Middleware de permissions (celui qu’on a ajouté)
        'permission' => \App\Http\Middleware\CheckPermission::class,
		
		// Middleware de roles
		'role' => \App\Http\Middleware\RoleMiddleware::class,
    ];

    /**
     * The application's middleware priority.
     *
     * Cet ordre garantit l’exécution correcte de certains middlewares.
     */
    protected $middlewarePriority = [
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\Authenticate::class,
        \Illuminate\Routing\Middleware\ThrottleRequests::class,
        \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        \App\Http\Middleware\CheckPermission::class, // Ajout ici aussi
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ];
}
