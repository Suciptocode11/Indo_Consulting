<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        $user = Auth::user();

        // Super Admin selalu memiliki akses ke seluruh modul
        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        // Cek apakah role user ada dalam daftar role yang diizinkan
        if (in_array($user->level, $roles)) {
            return $next($request);
        }

        // Khusus jika user finance mencoba mengakses halaman non-keuangan:
        if ($user->isFinance()) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Akses Ditolak: Akun Finance hanya berwenang mengakses modul Keuangan.');
        }

        // Khusus jika user admin mencoba mengakses modul keuangan:
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Akses Ditolak: Akun Admin tidak memiliki wewenang untuk mengakses modul Keuangan.');
        }

        abort(403, 'Akses Ditolak: Anda tidak memiliki wewenang untuk membuka halaman ini.');
    }
}

