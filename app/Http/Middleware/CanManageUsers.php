<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanManageUsers
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Super Admin selalu bisa, atau Admin yang punya izin can_manage_users
        if ($user->isSuperAdmin() || ($user->isAdmin() && $user->can_manage_users)) {
            return $next($request);
        }

        abort(403, 'Anda tidak memiliki izin untuk mengelola user.');
    }
}