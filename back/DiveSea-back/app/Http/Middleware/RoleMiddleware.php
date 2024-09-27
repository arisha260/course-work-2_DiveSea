<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Проверка аутентификации
        if (Auth::check() && (Auth::user()->role === 'author' || Auth::user()->role === 'admin')) {
            return $next($request);
        }

        // Если пользователь не авторизован или не имеет нужной роли
        return response()->json(['message' => 'Unauthorized'], 403);
    }
}
