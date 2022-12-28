<div class="row detail">
    <div class="col-md-10 col-sm-8 col-6">
        <dl class="row">
            <dt class="col-sm-5">Nama Pegawai:</dt>
            <dd class="col-sm-7">{{ $data->nama_pegawai }}</dd>
            <dt class="col-sm-5">Tanggal Absen:</dt>
            <dd class="col-sm-7">{{ $data->tgl_absen }}</dd>
            <dt class="col-sm-5">Waktu Datang:</dt>
            <dd class="col-sm-7">{{ $data->jam_masuk }}</dd>
            <dt class="col-sm-5">Waktu Pulang:</dt>
            <dd class="col-sm-7">
                @if (empty($data->jam_pulang))
                    Belum Absen Pulang
                @else
                    $data->jam_pulang
                @endif
            </dd>
            <dt class="col-sm-5">Status Kehadiran:</dt>
            <dd class="col-sm-7">{!! $data->formatted_status_pegawai !!}</dd>
            <dt class="col-sm-5">Keterangan Absen:</dt>
            <dd class="col-sm-7">{{ $data->keterangan_absen }}</dd>
        </dl>
    </div>
</div>

@if (config('settings.map_use'))
    <h4 class="my-2"><span class="fas fa-map-marked-alt mr-1"></span>Maps</h4>
    @if (!empty($data->maps_absen) && $data->maps_absen != 'No Location')
        <div id='maps-view-absen' style='width: 100%; height:250px;'></div>
        <a class="btn btn-primary my-2" href="http://maps.google.com/maps?q={{ $data->maps_absen }}"
            target="_blank"><span class="fas fa-fw fa-map-marker-alt mr-1"></span>Lihat Lokasi</a>
        <script>
            if (document.getElementById("maps-view-absen")) {
                var map = L.map('maps-view-absen').setView([{{ $data->maps_absen }}], 15);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                L.marker([{{ $data->maps_absen }}]).addTo(map);
            }
        </script>
    @else
        <div class="my-2 text-center">Lokasi Tidak Ditemukan</div>
    @endif
@endif
