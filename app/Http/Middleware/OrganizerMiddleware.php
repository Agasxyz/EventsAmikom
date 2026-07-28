<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrganizerMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('user.login');
        }

        $user = auth()->user();

        // Superadmin is allowed to view organizer dashboards/panels
        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        if (!$user->isOrganizer()) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk Penyelenggara.');
        }

        $org = $user->organization;
        if (!$org) {
            abort(403, 'Anda belum mendaftarkan organisasi Anda.');
        }

        if ($org->status !== 'active') {
            abort(403, 'Organisasi Anda berstatus: ' . strtoupper($org->status) . '. Silakan hubungi Superadmin.');
        }

        return $next($request);
    }
}
