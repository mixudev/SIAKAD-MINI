<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect($this->redirectTo(Auth::user()));
        }

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'identifier' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('identifier', $credentials['identifier'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'identifier' => 'Kredensial yang diberikan tidak cocok dengan data kami.',
            ])->onlyInput('identifier');
        }

        if (! $user->is_active) {
            return back()->withErrors([
                'identifier' => 'Akun ini telah dinonaktifkan. Silakan hubungi administrator.',
            ])->onlyInput('identifier');
        }

        Auth::login($user, $request->boolean('remember'));

        $user->update(['last_login_at' => now()]);

        $request->session()->regenerate();

        return redirect($this->redirectTo($user));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    private function redirectTo(User $user): string
    {
        if ($user->isAdmin()) {
            return route('admin.dashboard');
        }

        if ($user->isDosen()) {
            return route('dosen.dashboard');
        }

        if ($user->isMahasiswa()) {
            return route('mahasiswa.dashboard');
        }

        return route('dashboard');
    }
}
