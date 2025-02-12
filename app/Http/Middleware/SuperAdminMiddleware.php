<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user || $user->role->name !== 'Superadmin') {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses sebagai Super Admin.');
        }

        return $next($request);
    }
}