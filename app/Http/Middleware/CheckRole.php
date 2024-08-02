<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        foreach ($roles as $role) {
            if ($user->role->name === $role) {
                return $next($request);
            }
        }

        return redirect()->route('home');
    }
}

