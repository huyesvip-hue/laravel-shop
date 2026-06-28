<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PreventAdminAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        // chỉ chặn khi ĐÃ LOGIN và là admin
        if (Auth::check() && Auth::user()?->role_id === 1) {
            return redirect('/adm');
        }
        return $next($request);
    }
}