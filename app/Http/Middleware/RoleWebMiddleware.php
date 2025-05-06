<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleWebMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = Auth::user();

        // Cek langsung nilai ENUM di kolom 'role'
        if ($user && in_array($user->role, $roles)) {
            return $next($request);
        }

        abort(403, 'Unauthorized action.');
    }
}
