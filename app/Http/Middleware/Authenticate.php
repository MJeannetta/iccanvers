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
        // return $request->expectsJson() ? null : route('login');

        // Ajout d'un message flash à la session
        if (! $request->expectsJson()) {
            $request->session()->flash('error', 'Vous devez être connecté pour éxécuter cette action.');
        }
        
        // retoune l'URL de la page de connexion
        return route('login');
    }
}
