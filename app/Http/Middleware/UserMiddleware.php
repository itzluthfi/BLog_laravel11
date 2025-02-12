<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user || $user->role->name !== 'User') {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses sebagai User.');
        }

        return $next($request);
    }
}