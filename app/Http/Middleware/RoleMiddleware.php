<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk mengakses sistem.');
        }

        $user = auth()->user();

        // Jika status akun nonaktif
        if ($user->status_akun !== 'aktif') {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with('error', 'Akun Anda dinonaktifkan oleh pengurus RT.');
        }

        // Support role kelompok: 'pengurus' (admin, rt, sekretaris, bendahara)
        if (in_array('pengurus', $roles) && $user->isPengurus()) {
            return $next($request);
        }

        // Support role admin / rt equivalence
        if (in_array('admin', $roles) && ($user->role === 'admin' || $user->role === 'rt')) {
            return $next($request);
        }

        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        abort(403, 'Akses Ditolak: Anda tidak memiliki wewenang untuk membuka modul ini.');
    }
}
