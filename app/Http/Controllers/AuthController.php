<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. Tampilkan Form Login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // 2. Proses Login (Logic Pintar)
    public function login(Request $request)
    {
        // Validasi Input
        $request->validate([
            'identity' => 'required|string', // Bisa Email atau NIM
            'password' => 'required|string',
        ]);

        $identity = $request->input('identity');
        $password = $request->input('password');
        $remember = $request->boolean('remember');

        // LOGIC A: Cek apakah input adalah EMAIL? -> Maka Login ADMIN (User Database)
        if (filter_var($identity, FILTER_VALIDATE_EMAIL)) {
            if (Auth::guard('web')->attempt(['email' => $identity, 'password' => $password], $remember)) {
                $request->session()->regenerate();

                // === PERBAIKAN DI SINI ===
                // Redirect ke route 'admin.dashboard' (URL: /custom-admin/dashboard)
                return redirect()->intended(route('admin.dashboard'));
            }
        }

        // LOGIC B: Jika bukan Email (Angka/NIM) -> Maka Login ALUMNI
        else {
            if (Auth::guard('alumni')->attempt(['nim' => $identity, 'password' => $password], $remember)) {
                $request->session()->regenerate();

                // Redirect ke Dashboard Alumni
                return redirect()->intended(route('alumni.dashboard'));
            }
        }

        // Jika Gagal Semua
        return back()->withErrors([
            'identity' => 'NIM/Email atau Password salah.',
        ])->onlyInput('identity');
    }

    // 3. Proses Logout
    public function logout(Request $request)
    {
        // Cek guard mana yang sedang login
        if (Auth::guard('alumni')->check()) {
            Auth::guard('alumni')->logout();
        } elseif (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
