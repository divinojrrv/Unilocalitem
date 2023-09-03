<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserDataMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $usuario = [
            'user_id' => session('user_id'),
            'user_name' => session('user_name'),
            'user_tipousuario' => session('user_tipousuario'),
            'user_status' => session('user_status'),
        ];

        // Compartilha os dados do usuário com todas as views
        view()->share('user', $usuario);

        return $next($request);
    }
}
