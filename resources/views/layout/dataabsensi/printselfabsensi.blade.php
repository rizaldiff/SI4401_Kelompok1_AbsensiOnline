<link rel="stylesheet" href="{{ asset('assets/css/mpdf-bootstrap.css') }}">
<div class="container">
    <div class="jumbotron shadow-lg">
        <div class="text-center">
            <img src="{{ public_path(config('settings.logo_instansi')) }}" style="width:20%;">
            <h3>
                {{ config('settings.nama_instansi') }}
            </h3>
        </div>
    </div>
    <p class="my-2">Dibawah Ini Merupakan Data Absensi Yang Telah Terdata:</p>
    <div class="row detail">
        <div class="col-md-10 col-sm-8 col-6">
            <dl class="row">
                <dt class="col-sm-5">Nama Pegawai:</dt>
                <dd class="col-sm-7">{{ $data->nama_pegawai }}</dd>
                <dt class="col-sm-5">Tanggal Absen:</dt>
                <dd class="col-sm-7">{{ $data->formatted_tanggal_absen }}</dd>
                <dt class="col-sm-5">Waktu Datang:</dt>
                <dd class="col-sm-7">{{ $data->jam_masuk }}</dd>
                <dt class="col-sm-5">Waktu Pulang:</dt>
                <dd class="col-sm-7">{{ $data->jam_pulang ?: 'Belum Absen Pulang' }}</dd>
                <dt class="col-sm-5">Status Kehadiran:</dt>
                <dd class="col-sm-7">
                    @if ($data->status_pegawai == 1)
                        Sudah Absen
                    @elseif($data->status_pegawai == 2)
                        Absen Terlambat
                    @else
                        Belum Absen
                    @endif
                </dd>
                <dt class="col-sm-5">Keterangan Absen:</dt>
                <dd class="col-sm-7">{{ $data->keterangan_absen }}</dd>
                <dt class="col-sm-5">Titik Lokasi Maps:</dt>
                <dd class="col-sm-7">{{ $data->maps_absen ?: 'Lokasi Tidak Ada' }}</dd>
            </dl>
        </div>
    </div>
    <div class="text-right">
        <p>Atas Nama.</p>
        <p>{{ $data->nama_pegawai }}</p>
    </div>
    <div class="small">
        PDF was generated on <?= date('Y-m-d H:i:s') ?>
    </div>
</div>
