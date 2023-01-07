<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
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

            if (auth()->user()->is_active) {
                $user = User::where('username', $request->username)->first();
                $user->last_login = Carbon::now();
                $user->save();

                return redirect()->route('index');
            } else {
                $this->doLogout($request);

                return back()->withInput()->withErrors([
                    'login' => 'Akun Ini Belum Aktif, Silakan Hubungi Pihak Administrator!',
                ]);
            }
        }

        return back()->withInput()->withErrors([
            'login' => 'Password Atau Username Salah!',
        ]);
    }

    public function logout(Request $request)
    {
        $this->doLogout($request);

        $reponse = [
            'success' => true
        ];

        return json_encode($reponse);
    }

    public function doLogout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
    }
}
