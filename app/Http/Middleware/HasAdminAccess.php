<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class HasAdminAccess
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if (! $user || ! $user->active || $user->trashed()) {
            abort(403);
        }

        if ($user->role->key_name === 'app_user') {
            if ($request->is('admin/app*')) {
                return $next($request);
            }

            abort(403);
        }

        return $next($request);
    }

}
