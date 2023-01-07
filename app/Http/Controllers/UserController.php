<?php

namespace App\Http\Controllers;

use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function absensiku()
    {
        return view('user.absensi');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    public function setting(Request $request)
    {
        $user = Auth::user();
        $sessions = Session::where('user_id', Auth::user()->id)->where('id', '!=', $request->session()->getId())->get();
        return view('user.setting', compact('user', 'sessions'));
    }
}
