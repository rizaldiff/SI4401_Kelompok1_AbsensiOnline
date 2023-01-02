<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Image;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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

    public function getPegawaiDt(Request $request)
    {
        $draw = intval($request->draw);
        $data = [];

        $query = User::all();
        $admins = User::where('role_id', 1)->count();

        foreach ($query as $key => $value) {
            $data[] = array(
                $key+1,
                $value->nama_lengkap,
                $value->kode_pegawai,
                '<img class="img-thumbnail card-img" src="'.asset($value->image).'" style="width: 100%;" />',
                $value->username,
                $value->npwp ?: 'Tidak Ada',
                $value->jenis_kelamin,
                $value->level,
                $value->shift,
                $value->verification,
                ((($query->count() > 1 && $value->role_id !=1) || $admins > 1) && $value->id != Auth::user()->id) ? '<div class="btn-group btn-small " style="text-align: right;">
                    <button id="detailpegawai" class="btn btn-primary view-pegawai" data-pegawai-id="' . $value->id . '" title="Lihat Pegawai"><span class="fas fa-fw fa-address-card"></span></button>
                    <button class="btn btn-danger delete-pegawai" title="Hapus Pegawai" data-pegawai-id="' . $value->id . '"><span class="fas fa-trash"></span></button>
                    <button class="btn btn-warning edit-pegawai" title="Edit Pegawai" data-pegawai-id="' . $value->id . '"><span class="fas fa-user-edit"></span></button>
                    <button class="btn btn-secondary activate-pegawai" title="Verifikasi Pegawai" data-pegawai-id="' . $value->id . '"><span class="fas fa-user-check"></span></button>
                </div>' : '<div class="btn-group btn-small " style="text-align: right;">
                    <button id="detailpegawai" class="btn btn-primary view-pegawai" data-pegawai-id="' . $value->id . '" title="Lihat Pegawai"><span class="fas fa-fw fa-address-card"></span></button>
                    <button class="btn btn-warning edit-pegawai" title="Edit Pegawai" data-pegawai-id="' . $value->id . '"><span class="fas fa-user-edit"></span></button>
                    <button class="btn btn-secondary activate-pegawai" title="Verifikasi Pegawai" data-pegawai-id="' . $value->id . '"><span class="fas fa-user-check"></span></button>
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

    public function getDetailPegawai(Request $request)
    {
        $data = User::where('id', $request->pgw_id)->first();

        return view('layout/datapegawai/viewpegawai', compact('data'))->render();
    }

    public function actPegawai(Request $request)
    {
        $user = User::findOrFail($request->pgw_id);

        if ($user->is_active == 1) {
            $response = [
                'success' => false,
            ];
        } else {
            $user->is_active = 1;
            $user->save();

            $response = [
                'success' => true,
            ];
        }

        return response()->json($response);
    }

    public function editPegawai(Request $request)
    {
        $user = User::findOrFail($request->pgw_id);

        return view('layout/datapegawai/editpegawai', compact('user'))->render();
    }

    public function updatePegawai(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'nama_pegawai_edit' => 'required|string',
                'username_pegawai_edit' => 'required|string|unique:users,username,'.$request->id_pegawai_edit,
                'password_pegawai_edit' => 'nullable|string|min:8',
                'jabatan_pegawai_edit' => 'required|string',
                'npwp_pegawai_edit' => 'nullable|numeric',
                'umur_pegawai_edit' => 'required|numeric|min:1',
                'tempat_lahir_pegawai_edit' => 'required|string',
                'role_pegawai_edit' => 'required|in:1,2',
                'tgl_lahir_pegawai_edit' => 'required|date',
                'jenis_kelamin_pegawai_edit' => 'required|in:Laki - Laki,Perempuan',
                'shift_pegawai_edit' => 'required|in:1,2,3',
                'verifikasi_pegawai_edit' => 'required|in:0,1',
                'foto_pegawai_edit' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'barcode_pegawai_edit' => 'nullable',
            ], [], [
                'nama_pegawai_edit' => 'nama pegawai',
                'username_pegawai_edit' => 'username pegawai',
                'password_pegawai_edit' => 'password pegawai',
                'jabatan_pegawai_edit' => 'jabatan pegawai',
                'npwp_pegawai_edit' => 'npwp pegawai',
                'umur_pegawai_edit' => 'umur pegawai',
                'tempat_lahir_pegawai_edit' => 'tempat lahir pegawai',
                'role_pegawai_edit' => 'role pegawai',
                'tgl_lahir_pegawai_edit' => 'tanggal lahir pegawai',
                'jenis_kelamin_pegawai_edit' => 'jenis kelamin pegawai',
                'shift_pegawai_edit' => 'shift pegawai',
                'verifikasi_pegawai_edit' => 'verifikasi pegawai',
                'foto_pegawai_edit' => 'foto pegawai',
                'barcode_pegawai_edit' => 'barcode pegawai',
            ]
        );

        if ($validator->fails()) {
            $errorsHtml = '<ul>';
            foreach ($validator->errors()->all() as $error) {
                $errorsHtml .= '<li>' . $error . '</li>';
            }
            $errorsHtml .= '</ul>';

            $response = [
                'success' => false,
                'messages' => '<div class="alert alert-danger" role="alert"><h6 class="mb-0">Error:</h6>'.$errorsHtml.'</div>'
            ];
        } else {
            $user = User::findOrFail($request->id_pegawai_edit);

            $user->nama_lengkap = $request->nama_pegawai_edit;
            $user->username = $request->username_pegawai_edit;
            if ($request->password_pegawai_edit != null) {
                $user->password = Hash::make($request->password_pegawai_edit);
            }
            $user->jabatan = $request->jabatan_pegawai_edit;
            $user->npwp = $request->npwp_pegawai_edit;
            $user->umur = $request->umur_pegawai_edit;
            $user->tempat_lahir = $request->tempat_lahir_pegawai_edit;
            $user->role_id = $request->role_pegawai_edit;
            $user->tgl_lahir = $request->tgl_lahir_pegawai_edit;
            $user->jenis_kelamin = $request->jenis_kelamin_pegawai_edit;
            $user->bagian_shift = $request->shift_pegawai_edit;
            $user->is_active = $request->verifikasi_pegawai_edit;
            if ($request->foto_pegawai_edit != null) {
                if (file_exists($user->image) && $user->image != "storage/profiles/default.jpg") {
                    unlink($user->image);
                }

                $path = $request->foto_pegawai_edit->store('profiles', 'public');
                $newImagePath = 'storage/'.$path;
                if(extension_loaded("gd")||extension_loaded("gd2")){
                    $newImage = Image::make($newImagePath)->resize(null,300, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->resizeCanvas(300, 300, 'center');
                    $newImage->save($newImagePath, 90);
                }
                $user->image = $newImagePath;
            }

            if ($request->barcode_pegawai_edit != null) {
                if ($user->qr_code_image == 'storage/qr_codes/no-qrcode.png' || !file_exists($user->qr_code_image)) {
                    $image = QrCode::format('png')->generate($user->kode_pegawai);
                    $newImagePath = 'storage/qr_codes/'.$user->kode_pegawai.'.png';
                    Storage::disk('public')->put('qr_codes/'.$user->kode_pegawai.'.png', $image);
                    $user->qr_code_image = $newImagePath;
                }
                $user->qr_code_use = 1;
            } else {
                if ($user->qr_code_image != 'storage/qr_codes/no-qrcode.png') {
                    unlink($user->qr_code_image);
                }
                $user->qr_code_image = 'storage/qr_codes/no-qrcode.png';
                $user->qr_code_use = 0;
            }

            $user->save();

            $response = [
                'success' => true,
            ];
        }

        return response()->json($response);
    }

    public function storePegawai(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'nama_pegawai' => 'required|string',
                'username_pegawai' => 'required|string|unique:users,username',
                'password_pegawai' => 'required|string|min:8',
                'jabatan_pegawai' => 'required|string',
                'npwp_pegawai' => 'nullable|numeric',
                'umur_pegawai' => 'required|numeric|min:1',
                'tempat_lahir_pegawai' => 'required|string',
                'role_pegawai' => 'required|in:1,2',
                'tgl_lahir_pegawai' => 'required|date',
                'jenis_kelamin_pegawai' => 'required|in:Laki - Laki,Perempuan',
                'shift_pegawai' => 'required|in:1,2,3',
                'verifikasi_pegawai' => 'required|in:0,1',
                'foto_pegawai_edit' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'barcode_pegawai' => 'nullable',
            ], [], [
                'nama_pegawai_edit' => 'nama pegawai',
                'username_pegawai_edit' => 'username pegawai',
                'password_pegawai_edit' => 'password pegawai',
                'jabatan_pegawai_edit' => 'jabatan pegawai',
                'npwp_pegawai_edit' => 'npwp pegawai',
                'umur_pegawai_edit' => 'umur pegawai',
                'tempat_lahir_pegawai_edit' => 'tempat lahir pegawai',
                'role_pegawai_edit' => 'role pegawai',
                'tgl_lahir_pegawai_edit' => 'tanggal lahir pegawai',
                'jenis_kelamin_pegawai_edit' => 'jenis kelamin pegawai',
                'shift_pegawai_edit' => 'shift pegawai',
                'verifikasi_pegawai_edit' => 'verifikasi pegawai',
                'foto_pegawai_edit' => 'foto pegawai',
                'barcode_pegawai' => 'barcode pegawai',
            ]
        );

        if ($validator->fails()) {
            $errorsHtml = '<ul>';
            foreach ($validator->errors()->all() as $error) {
                $errorsHtml .= '<li>' . $error . '</li>';
            }
            $errorsHtml .= '</ul>';

            $response = [
                'success' => false,
                'messages' => '<div class="alert alert-danger" role="alert"><h6 class="mb-0">Error:</h6>'.$errorsHtml.'</div>'
            ];
        } else {
            $user = new User();

            $user->nama_lengkap = $request->nama_pegawai;
            $user->username = $request->username_pegawai;
            $user->password = Hash::make($request->password_pegawai);
            $user->jabatan = $request->jabatan_pegawai;
            $user->npwp = $request->npwp_pegawai;
            $user->umur = $request->umur_pegawai;
            $user->instansi = config('settings.nama_instansi');
            $user->tempat_lahir = $request->tempat_lahir_pegawai;
            $user->role_id = $request->role_pegawai;
            $user->tgl_lahir = $request->tgl_lahir_pegawai;
            $user->jenis_kelamin = $request->jenis_kelamin_pegawai;
            $user->bagian_shift = $request->shift_pegawai;
            $user->is_active = $request->verifikasi_pegawai;
            $user->kode_pegawai = $this->generateKodePegawai();
            $user->last_login = Carbon::now();
            $user->created_at = Carbon::now();
            $user->updated_at = Carbon::now();

            if ($request->foto_pegawai != null) {
                $path = $request->foto_pegawai->store('profiles', 'public');
                $newImagePath = 'storage/'.$path;
                if (extension_loaded("gd")||extension_loaded("gd2")) {
                    $newImage = Image::make($newImagePath)->resize(null,300, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->resizeCanvas(300, 300, 'center');
                    $newImage->save($newImagePath, 90);
                }
                $user->image = $newImagePath;
            } else {
                $user->image = 'storage/profiles/default.jpg';
            }

            if ($request->barcode_pegawai != null) {
                $image = QrCode::format('png')->generate($user->kode_pegawai);
                $newImagePath = 'storage/qr_codes/'.$user->kode_pegawai.'.png';
                Storage::disk('public')->put('qr_codes/'.$user->kode_pegawai.'.png', $image);
                $user->qr_code_image = $newImagePath;
                $user->qr_code_use = 1;
            } else {
                $user->qr_code_image = 'storage/qr_codes/no-qrcode.png';
                $user->qr_code_use = 0;
            }

            $user->save();

            $response = [
                'success' => true
            ];
        }

        return response()->json($response);
    }

    private function generateKodePegawai()
    {
        $number = '';

        do {
            for ($i=15; $i > 0; $i--) {
                $number .= mt_rand(0, 9);
            }
        } while (User::where('kode_pegawai', $number)->first() != null);

        return $number;
    }

    public function deletePegawai(Request $request)
    {
        $response = [
            'success' => false,
            'message' => ''
        ];

        if (auth()->user()->role_id != 1 || User::where('role_id', 1)->count() <= 1) {
            $response['message'] = 'Hanya admin yang boleh menghapus user!';
        } else {
            $user = User::find($request->pgw_id);
            if ($user->image != 'storage/profiles/default.jpg' && file_exists($user->image)) {
                unlink($user->image);
            }
            if ($user->qr_code_image != 'storage/qr_codes/no-qrcode.png' && file_exists($user->qr_code_image)) {
                unlink($user->qr_code_image);
            }
            $user->delete();
            $response = [
                'success' => true,
                'message' => 'Pegawai berhasil dihapus!'
            ];
        }

        return response()->json($response);
    }

    public function absensi(Request $request)
    {
        $draw = intval($request->draw);
        $data = [];

        $query = Attendance::orderBy('tgl_absen', 'DESC')->get();

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
                    <button class="btn btn-danger delete-absen" title="Hapus Absensi" data-absen-id="' . $value->id . '"><span class="fas fa-trash"></span></button>
                    <button class="btn btn-warning print-absen" title="Cetak Absensi" data-absen-id="' . $value->id . '" data-toggle="modal" data-target="#printabsensimodal"><span class="fas fa-print"></span></button>
                </div>'
            );
        }

        $result = array(
            "draw" => $draw,
            "recordsTotal" => $query->count(),
            "recordsFiltered" => $query->count(),
            "data" => $data
        );

        return response()->json($result);
    }

    public function hapusAbsensi(Request $request)
    {
        $response = [
            'success' => false,
            'message' => 'Absensi gagal dihapus!'
        ];

        $absensi = Attendance::find($request->absen_id);
        if ($absensi->delete()) {
            $response = [
                'success' => true,
                'message' => 'Absensi berhasil dihapus!'
            ];
        }

        return response()->json($response);
    }

    public function hapusSemuaAbsensi(Request $request)
    {
        $response = [
            'success' => false,
            'message' => 'Absensi gagal dihapus!'
        ];

        if (Attendance::truncate()) {
            $response = [
                'success' => true,
                'message' => 'Absensi berhasil dihapus!'
            ];
        }

        return response()->json($response);
    }
}
