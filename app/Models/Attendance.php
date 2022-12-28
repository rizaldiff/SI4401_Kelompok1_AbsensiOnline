<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_pegawai',
        'kode_pegawai',
        'tgl_absen',
        'jam_masuk',
        'jam_pulang',
        'status_pegawai',
        'keterangan_absen',
        'maps_absen',
    ];

    public static function todayAttendance($kodePegawai)
    {
        return Attendance::where('tgl_absen', date('Y-m-d'))->where('kode_pegawai', $kodePegawai)->first();
    }

    public function getFormattedStatusPegawaiAttribute()
    {
        if ($this->status_pegawai == null) {
            return '<span class="badge badge-primary">Belum Absen</span>';
        } elseif ($this->status_pegawai == 1) {
            return '<span class="badge badge-success">Sudah Absen</span>';
        } else {
            return '<span class="badge badge-danger">Absen Terlambat</span>';
        }
    }

    public static function doAbsen($kodePegawai, $ketAbsen, $mapsAbsen)
    {
        $appsettings = Setting::first();
        $today = date('Y-m-d');
        $clocknow = date("H:i:s");
        $absensi = Attendance::where('tgl_absen', $today)
            ->where('kode_pegawai', $kodePegawai)
            ->get();
        $pegawai = User::where('kode_pegawai', $kodePegawai)->first();

        if (strtotime($clocknow) >= strtotime($appsettings['absen_mulai']) && strtotime($clocknow) <= strtotime($appsettings['absen_mulai_to'])) {
            if ($absensi->count() > 0) {
                $absen = $absensi->first();
                $absen->jam_masuk = $clocknow;
                $absen->save();
            } else {
                $data = [
                    'nama_pegawai' => $pegawai['nama_lengkap'],
                    'kode_pegawai' => $kodePegawai,
                    'jam_masuk' => $clocknow,
                    'id_absen' => uniqid('absen_'),
                    'tgl_absen' => $today,
                    'keterangan_absen' => htmlspecialchars($ketAbsen),
                    'status_pegawai' => 1,
                    'maps_absen' => $appsettings['map_use'] ? htmlspecialchars($mapsAbsen) : 'No Location'
                ];
                $absen = new Attendance();
                $absen->fill($data);
                $absen->save();
            }
        } elseif (strtotime($clocknow) > strtotime($appsettings['absen_mulai_to']) && strtotime($clocknow) >= strtotime($appsettings['absen_pulang'])) {
            if ($absensi->count() > 0) {
                $absen = $absensi->first();
                $absen->jam_pulang = $clocknow;
                $absen->save();
            } else {
                $data = [
                    'nama_pegawai' => $pegawai['nama_lengkap'],
                    'kode_pegawai' => $kodePegawai,
                    'jam_masuk' => $clocknow,
                    'id_absen' => uniqid('absen_'),
                    'tgl_absen' => $today,
                    'keterangan_absen' => htmlspecialchars($ketAbsen),
                    'status_pegawai' => 2,
                    'maps_absen' => $appsettings['map_use'] ? htmlspecialchars($mapsAbsen) : 'No Location'
                ];
                $absen = new Attendance();
                $absen->fill($data);
                $absen->save();
            }
        } elseif (strtotime($clocknow) > strtotime($appsettings['absen_mulai_to']) && strtotime($clocknow) <= strtotime($appsettings['absen_pulang'])) {
            $data = [
                'nama_pegawai' => $pegawai['nama_lengkap'],
                'kode_pegawai' => $kodePegawai,
                'jam_masuk' => $clocknow,
                'id_absen' => uniqid('absen_'),
                'tgl_absen' => $today,
                'keterangan_absen' => htmlspecialchars($ketAbsen),
                'status_pegawai' => 2,
                'maps_absen' => $appsettings['map_use'] ? htmlspecialchars($mapsAbsen) : 'No Location'
            ];
            $absen = new Attendance();
            $absen->fill($data);
            $absen->save();
        }
    }
}
