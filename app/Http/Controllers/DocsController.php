<?php

namespace App\Http\Controllers;

use App\Exports\AttendancesExport;
use App\Models\Attendance;
use Illuminate\Http\Request;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class DocsController extends Controller
{
    public function cetak(Request $request)
    {
        if (!empty($request->id_absen)) {
            $data = [
                'data' => Attendance::where('id', $request->id_absen)->first(),
            ];

            $pdf = PDF::loadView('layout.dataabsensi.printselfabsensi', $data);

            return $pdf->stream('document.pdf');
        } else {
            return redirect(route('absensi'));
        }
    }

    public function export()
    {
        return view('admin.exportfile');
    }

    public function exportAbsensi(Request $request)
    {
        $type = $request->method_export_file;

        $query = Attendance::query();
        if ($request->nama_pegawai) {
            $query->where('nama_pegawai', $request->nama_pegawai);
        }
        if ($request->absen_tahun) {
            $query->whereYear('tgl_absen', $request->absen_tahun);
        }
        if ($request->absen_bulan) {
            $arrayBulan = array(
                "Januari" => 1,
                "Februari" => 2,
                "Maret" => 3,
                "April" => 4,
                "Mei" => 5,
                "Juni" => 6,
                "Juli" => 7,
                "Agustus" => 8,
                "September" => 9,
                "Oktober" => 10,
                "November" => 11,
                "Desember" => 12
            );

            $query->whereMonth('created_at', $arrayBulan[$request->absen_bulan]);
        }
        $dataAbsensi = $query->get();

        if ($type == 'pdf') {
            $data = [
                'dataabsensi' => $dataAbsensi,
            ];

            $pdf = PDF::loadView('layout.dataabsensi.printallabsensi', $data);

            return $pdf->stream('document.pdf');
        } elseif ($type == 'excel') {
            // make array from collection
            $dataArray = [];

            foreach ($dataAbsensi as $absen) {
                $dataArray[] = [
                    'id' => $absen->id,
                    'nama_pegawai' => $absen->nama_pegawai,
                    'tgl_absen' => $absen->tgl_absen,
                    'jam_masuk' => $absen->jam_masuk,
                    'jam_keluar' => $absen->jam_keluar ?: 'Belum Absen Pulang',
                    'status_pegawai' => ($absen->status_pegawai == 1) ? 'Sudah Absen' : 'Absen Terlambat',
                    'keterangan_absen' => $absen->keterangan_absen,
                    'maps_absen' => $absen->maps_absen,
                ];
            }

            return Excel::download(new AttendancesExport($dataArray), 'absensi.xlsx');
        } else {
            return redirect(route('absensi'));
        }
    }
}
