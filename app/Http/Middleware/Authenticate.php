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
        if (! $request->expectsJson()) {
            // Adicione uma mensagem de erro à sessão
            session()->flash('error', 'Você precisa estar autenticado para acessar esta página via HTTP.');
    
            return route('login.telainicial');
        }
    }

    

}
