<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->appdata = Setting::first();
    }

    public function login()
    {
        $appdata = $this->appdata;
        return view('auth.login', compact('appdata'));
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required|exists:users',
            'password' => 'required',
        ], [
            'username.required' => 'You must provide a Username.',
            'username.exists' => 'Akun Belum Terdaftar!',
            'password.required' => 'You must provide a Password.',
        ]);

        $credentials = $request->only('username', 'password');

        if (auth()->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'login' => 'Password Atau Username Salah!',
        ]);
    }

    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $reponse = [
            'success' => true
        ];

        return json_encode($reponse);
    }
}
