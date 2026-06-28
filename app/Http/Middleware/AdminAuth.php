<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        // chưa login
        if (!Auth::check()) {
            return redirect('/dangnhap');
        }

        // không phải admin
        if (Auth::user()->role_id != 1) {
            abort(403);
        }

        return $next($request);
    }
}