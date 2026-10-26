<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        if (! in_array($user->role, $roles, true)) {
            // If user role is not authorized, redirect to their home
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard')->with('error', 'Akses dialihkan ke dashboard Admin.');
            }

            return redirect()->route('home')->with('error', 'Anda tidak memiliki hak akses untuk halaman tersebut.');
        }

        return $next($request);
    }
}
