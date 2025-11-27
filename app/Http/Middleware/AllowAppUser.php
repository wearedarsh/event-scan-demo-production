<?php 

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AllowAppUser
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if (
            $user &&
            $user->active &&
            ! $user->trashed() &&
            $user->role->key_name === 'App user'
        ) {
            return $next($request);
        }

        abort(403);
    }
}
