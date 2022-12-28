<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->appdata = Setting::first();
    }

    public function index()
    {
        if (date("H") < 4) {
			$greet = 'Selamat Malam';
		} elseif (date("H") < 11) {
			$greet = 'Selamat Pagi';
		} elseif (date("H") < 16) {
			$greet = 'Selamat Siang';
		} elseif (date("H") < 18) {
			$greet = 'Selamat Sore';
		} else {
			$greet = 'Selamat Malam';
		}

        $data = [
            'greeting' => $greet,
            'appdata' => $this->appdata,
            'attendance' => Attendance::todayAttendance(Auth::user()->kode_pegawai),
        ];

        return view('front.home', $data);
    }

    public function dashboard()
    {
        $query_absensi = Attendance::where('tgl_absen', date('Y-m-d'))->get();

        $data = [
            'appdata' => $this->appdata,
            'jmlpegawai' => User::count(),
            'pegawaitelat' => $query_absensi->where('status_pegawai', 2)->count(),
            'pegawaimasuk' => $query_absensi->where('status_pegawai', 1)->count()
        ];

        return view('admin.dashboard', $data);
    }
}