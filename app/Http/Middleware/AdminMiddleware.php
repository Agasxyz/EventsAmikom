<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('user.login');
        }

        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk Administrator.');
        }

        return $next($request);
    }
}
