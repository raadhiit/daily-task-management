<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$levels): Response
    {

        $user = $request->user();

        // Periksa jika pengguna adalah Foreman (level 2) dengan id_mch
        if ($user->level === 2 && $request->session()->has('id_mch')) {
            return $next($request); // Foreman dengan id_mch diizinkan akses
        }
    
        if (in_array($user->level, $levels)) {
            return $next($request); // Pengguna dengan level sesuai diizinkan akses
        }
        abort(Response::HTTP_FORBIDDEN, '403 Unauthorized');
    }
}
