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
    <table class="table">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Pegawai</th>
                <th scope="col">Tanggal Absen</th>
                <th scope="col">Jam Datang</th>
                <th scope="col">Jam Pulang</th>
                <th scope="col">Status Kehadiran</th>
                <th scope="col">Keterangan Absen</th>
                <th scope="col">Titik Lokasi Maps</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataabsensi as $data)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $data->nama_pegawai }}</td>
                    <td>{{ $data->formatted_tanggal_absen }}</td>
                    <td>{{ $data->jam_masuk }}</td>
                    <td>{{ $data->jam_pulang ?: 'Belum Absen Pulang' }}</td>
                    <td>
                        @if ($data->status_pegawai == 1)
                            Sudah Absen
                        @elseif($data->status_pegawai == 2)
                            Absen Terlambat
                        @else
                            Belum Absen
                        @endif
                    </td>
                    <td>{{ $data->keterangan_absen }}</td>
                    <td>{{ $data->maps_absen ?: 'Lokasi Tidak Ada' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="small">
        PDF was generated on <?= date('Y-m-d H:i:s') ?>
    </div>
</div>
