<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create()
{
    if (auth()->check()) {
        $user = auth()->user();
        return match ($user->role) {
            'admin' => redirect()->route('dashboard'),
            'tim_desain' => redirect()->route('designs.index'),
            'tim_produksi' => redirect()->route('productions.index'),
            'driver' => redirect()->route('delivery.index'),
            'logistik' => redirect()->route('pickup.index'),
            default => redirect()->route('login'),
        };
    }

    return view('auth.login');
}


    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
{
    // 🔹 VALIDASI RECAPTCHA
    $request->validate([
        'g-recaptcha-response' => ['required'],
    ]);

    // 🔹 VERIFIKASI KE GOOGLE
    $response = \Illuminate\Support\Facades\Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
        'secret' => env('RECAPTCHA_SECRET_KEY'),
        'response' => $request->input('g-recaptcha-response'),
        'remoteip' => $request->ip(),
    ]);

    if (! $response->json('success')) {
        return back()->withErrors(['g-recaptcha-response' => 'Captcha gagal, coba lagi.']);
    }

    // 🔹 AUTENTIKASI BAWAAN BREEZE
    $request->authenticate();

    $request->session()->regenerate();

    $user = Auth::user();

    switch ($user->role) {
        case 'admin':
            return redirect()->route('dashboard');

        case 'tim_desain':
            return redirect()->route('designs.index');

        case 'tim_produksi':
            return redirect()->route('productions.index');

        case 'driver':
            return redirect()->route('delivery.index');

        case 'logistik':
            return redirect()->route('pickup.index');

        default:
                return redirect()->route('login');
    }
}


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

           return redirect()->route('login');
    }
}
