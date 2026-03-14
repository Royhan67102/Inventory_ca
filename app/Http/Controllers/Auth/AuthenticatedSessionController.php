<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display login page
     */
    public function create()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role);
        }

        return view('auth.login');
    }

    /**
     * Handle login
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Validasi captcha
        $request->validate([
            'g-recaptcha-response' => ['required'],
        ]);

        // Verifikasi captcha ke Google
        $response = Http::asForm()->post(
            'https://www.google.com/recaptcha/api/siteverify',
            [
                'secret' => env('RECAPTCHA_SECRET_KEY'),
                'response' => $request->input('g-recaptcha-response'),
                'remoteip' => $request->ip(),
            ]
        );

        if (!$response->json('success')) {
            return back()->withErrors([
                'g-recaptcha-response' => 'Captcha gagal, coba lagi.',
            ]);
        }

        // Login
        $request->authenticate();
        $request->session()->regenerate();

        return $this->redirectByRole(Auth::user()->role);
    }

    /**
     * Redirect user berdasarkan role
     */
    private function redirectByRole($role): RedirectResponse
    {
        $route = match ($role) {

            'admin' => 'dashboard',

            'tim_desain' => 'designs.index',

            'tim_produksi' => 'productions.index',

            'driver' => 'delivery.index',

            'driver1' => 'pickup.index',

            'logistik' => 'inventories.index',

            default => 'login'
        };

        return redirect()->route($route);
    }

    /**
     * Logout
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
