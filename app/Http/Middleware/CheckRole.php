<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        switch ($role) {
            case 'admin':
                if (!$user->isAdmin()) {
                    abort(403, 'Unauthorized. Admin access required.');
                }
                break;
            case 'customer':
                if (!$user->isCustomer()) {
                    abort(403, 'Unauthorized. Customer access required.');
                }
                break;
            default:
                abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}