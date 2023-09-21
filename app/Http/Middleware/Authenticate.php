<?php
namespace App\Http\Middleware;

use Auth;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades;
use Closure;


class Authenticate
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

