<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        // Verifica si el usuario está autenticado y es un administrador
        if (Auth::check() && Auth::user()->hasRole('Admin')) {
            return $next($request);
        }

        // Si el usuario no es un administrador, redirige o muestra un mensaje de error
        return redirect()->route('nuevo.index');
    }
}
