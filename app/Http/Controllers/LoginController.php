<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function Login()
    {
        return view('backend.login.login', [
            'judul' => 'innap',
            'subjudul' => 'Hotel',
        ]);
    }

    public function Authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            if (Auth::User()->status == 0) {
                Auth::logout();
                return back()->with('error', 'User Belum Aktif');
            }
            $request->session()->regenerate();
            return redirect()->intended(route('backend.dashboard'));
        }
        return back()->with('error', 'Login Gagal');
    }

    public function Logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect(route('backend.login'));
    }
}
