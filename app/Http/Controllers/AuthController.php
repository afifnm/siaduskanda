<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse|JsonResponse
    {
        $credentials = $request->validated();
        $identifier = $credentials['email'];
        $password = $credentials['password'];
        $remember = (bool) ($credentials['remember'] ?? true);

        // Attempt login by email or nip_nisn strictly for admin
        $user = User::where(function ($query) use ($identifier) {
            $query->where('email', $identifier)
                ->orWhere('nip_nisn', $identifier);
        })
            ->where('role', 'admin')
            ->first();

        if ($user && Auth::attempt(['email' => $user->email, 'password' => $password], $remember)) {
            $request->session()->regenerate();

            $redirectUrl = route('admin.dashboard');

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Login berhasil. Mengalihkan ke dashboard admin...',
                    'data' => [
                        'user' => $user,
                        'redirect_url' => $redirectUrl,
                    ],
                ]);
            }

            return redirect()->intended($redirectUrl);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Kredensial tidak valid atau akun bukan Administrator.',
                'errors' => [
                    'email' => ['Kredensial email atau kata sandi admin tidak valid.'],
                ],
            ], 422);
        }

        return back()
            ->withErrors(['email' => 'Kredensial email atau kata sandi admin tidak valid.'])
            ->withInput();
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Anda telah berhasil keluar.');
    }
}
