<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    public function absenajax(Request $request)
    {
        $clocknow = date("H:i:s");
        $today = Carbon::now()->format('Y-m-d');
        $appsettings = Setting::first();
        $isPulang = Attendance::where('tgl_absen', $today)
            ->where('kode_pegawai', Auth::user()->kode_pegawai)
            ->first();
        if (strtotime($clocknow) <= strtotime($appsettings['absen_mulai'])) {
            $reponse = [
                'success' => false,
                'msgabsen' => '<div class="alert alert-danger text-center" role="alert">Belum Waktunya Absen Datang</div>'
            ];
        } elseif (strtotime($clocknow) >= strtotime($appsettings['absen_mulai_to']) && strtotime($clocknow) <= strtotime($appsettings['absen_pulang']) && $isPulang) {
            $reponse = [
                'success' => false,
                'msgabsen' => '<div class="alert alert-danger text-center" role="alert">Belum Waktunya Absen Pulang</div>'
            ];
        } elseif (strtotime($clocknow) >= strtotime($appsettings['absen_mulai_to']) && strtotime($clocknow) >= strtotime($appsettings['absen_pulang']) && !empty($isPulang['jam_pulang'])) {
            $reponse = [
                'success' => false,
                'msgabsen' => '<div class="alert alert-danger text-center" role="alert">Anda Sudah Absen Pulang</div>'
            ];
        } else {
            Attendance::doAbsen(Auth::user()->kode_pegawai, $request->ket_absen, $request->maps_absen);
            $reponse = [
                'success' => true
            ];
        }
        echo json_encode($reponse);
    }

    public function getPegawaiTerlambatDt(Request $request)
    {
        $draw = intval($request->draw);
        $data = [];

        $query = Attendance::where('status_pegawai', 2)
            ->where('tgl_absen', date('Y-m-d'))
            ->orderBy('jam_masuk', 'ASC')
            ->get();

        foreach ($query as $key => $value) {
            $data[] = array(
                $key+1,
                $value->jam_masuk,
                $value->nama_pegawai,
                $value->formatted_status_pegawai,
            );
        }

        $result = array(
            "draw" => $draw,
            "recordsTotal" => $query->count(),
            "recordsFiltered" => $query->count(),
            "data" => $data
        );

        echo json_encode($result);
    }

    public function getPegawaiMasukDt(Request $request)
    {
        $draw = intval($request->draw);
        $data = [];

        $query = Attendance::where('status_pegawai', 1)
            ->where('tgl_absen', date('Y-m-d'))
            ->orderBy('jam_masuk', 'ASC')
            ->get();

        foreach ($query as $key => $value) {
            $data[] = array(
                $key+1,
                $value->jam_masuk,
                $value->nama_pegawai,
                $value->formatted_status_pegawai,
            );
        }

        $result = array(
            "draw" => $draw,
            "recordsTotal" => $query->count(),
            "recordsFiltered" => $query->count(),
            "data" => $data
        );

        echo json_encode($result);
    }

    public function getAbsensikuDt(Request $request)
    {
        $draw = intval($request->draw);
        $data = [];

        $query = Attendance::where('kode_pegawai', Auth::user()->kode_pegawai)
            ->orderBy('tgl_absen', 'DESC')
            ->get();

        foreach ($query as $key => $value) {
            $data[] = array(
                $key+1,
                Carbon::parse($value->tgl_absen)->translatedFormat('l, d F Y'),
                $value->nama_pegawai,
                $value->jam_masuk ?? '',
                $value->jam_pulang ?? '',
                $value->formatted_status_pegawai,
                '<div class="btn-group btn-small " style="text-align: right;">
                    <button class="btn btn-primary detail-absen" data-absen-id="' . $value->id . '" title="Lihat Absensi"><span class="fas fa-fw fa-address-card"></span></button>
                    </div>'
            );
        }

        $result = array(
            "draw" => $draw,
            "recordsTotal" => $query->count(),
            "recordsFiltered" => $query->count(),
            "data" => $data
        );

        echo json_encode($result);
    }

    public function getDetailAbsensi(Request $request)
    {
        $data = Attendance::where('id', $request->absen_id)->first();

        return view('layout/dataabsensi/viewabsensi', compact('data'))->render();
    }
}
