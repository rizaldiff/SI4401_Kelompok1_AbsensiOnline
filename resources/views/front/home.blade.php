@extends('layout.main')
@section('title', config('settings.nama_app_absensi'))
@section('content')
    <div class="container-fluid">
        <div class="mt-4 jumbotron jumbotron-fluid shadow-lg">
            <div class="container">
                <div class="text-center">
                    <img src="{{ asset(config('settings.logo_instansi')) }}" class="card-img" style="width:15%;" alt="Logo">
                    <h1 class="display-5">{{ config('settings.nama_instansi') }}</h1>
                    <h4>
                        <div class="d-inline">{{ $greeting }}</div>,
                        {{ auth()->user()->nama_lengkap }}
                    </h4>
                    <p class="lead">
                        <marquee width="60%" direction="left">
                            {{ config('settings.jumbotron_lead_set') }}</marquee>
                    </p>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-xl-7">
                <div class="card mb-4">
                    <div class="card-header text-center">
                        <span class="fas fa-user mr-1"></span>Identitas Diri
                        <div class="float-right">
                            <button id="qrcode-pegawai" class="btn btn-primary" data-toggle="modal"
                                data-target="#qrcodemodal"><span class="fas fa-qrcode mr-1"></span>QR
                                CODE</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row detail">
                            <div class="col-md-2 col-sm-4 col-6 p-2">
                                <img class="img-thumbnail" src="{{ asset(auth()->user()->image) }}" class="card-img"
                                    style="width:100%;" alt="Profile Picture">
                            </div>
                            <div class="col-md-10 col-sm-8 col-6">
                                <dl class="row">
                                    <dt class="col-sm-5">Nama Lengkap:</dt>
                                    <dd class="col-sm-7">{{ auth()->user()->nama_lengkap }}</dd>
                                    <dt class="col-sm-5">Umur:</dt>
                                    <dd class="col-sm-7">{{ auth()->user()->umur }}<div class="ml-1 d-inline">Tahun</div>
                                    </dd>
                                    <dt class="col-sm-5">Instansi:</dt>
                                    <dd class="col-sm-7 text-truncate">{{ auth()->user()->instansi }}</dd>
                                    <dt class="col-sm-5">Jabatan:</dt>
                                    <dd class="col-sm-7">{{ auth()->user()->jabatan }}</dd>
                                    <dt class="col-sm-5">NPWP:</dt>
                                    <dd class="col-sm-7">{{ auth()->user()->npwp }}</dd>
                                    <dt class="col-sm-5">Tempat / Tanggal Lahir:</dt>
                                    <dd class="col-sm-7">{{ auth()->user()->tempat_tanggal_lahir }}</dd>
                                    <dt class="col-sm-5">Jenis Kelamin:</dt>
                                    <dd class="col-sm-7">{{ auth()->user()->jenis_kelamin }}</dd>
                                    <dt class="col-sm-5">Shift Bekerja:</dt>
                                    <dd class="col-sm-7">{!! auth()->user()->shift_pegawai !!}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Kode Pegawai: {{ auth()->user()->kode_pegawai }}</div>
                            <div class="text-muted">Akun Dibuat: {{ auth()->user()->akun_dibuat }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-5">
                <div class="card mb-4">
                    <div class="card-header text-center"><span class="fas fa-clock mr-1"></span>Absensi
                    </div>
                    <div class="card-body text-center">
                        <div id="infoabsensi"></div>
                        @if (config('settings.map_use'))
                            <div id='maps-absen' style='width: 100%; height:250px;'></div>
                            <hr>
                        @endif
                        <div id="location-maps" style="display: none;"></div>
                        <div id="date-and-clock">
                            <h3 id="clocknow"></h3>
                            <h3 id="datenow"></h3>
                        </div>
                        <select name="ket_absen" class="form-control align-content-center my-2" id="ket_absen">
                            <option value="Bekerja Di Kantor">Bekerja Di Kantor</option>
                            <option value="Bekerja Di Rumah / WFH">Bekerja Di Rumah / WFH</option>
                            <option value="Sakit">Sakit</option>
                            <option value="Cuti">Cuti</option>
                        </select>
                        <div class="mt-2">
                            <div id="func-absensi">
                                <p class="font-weight-bold">Status Kehadiran: {!! $attendance->formatted_status_pegawai ?? '<span class="badge badge-primary">Belum Absen</span>' !!}
                                </p>
                                <div id="jamabsen">
                                    <p>Waktu Datang: {{ $attendance->jam_masuk ?? '00:00:00' }}</p>
                                    <p>Waktu Pulang: {{ $attendance->jam_pulang ?? '00:00:00' }}</p>
                                </div>
                            </div>
                            <button class="btn btn-dark" id="btn-absensi">Absen</button>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="text-muted">Absen Datang Jam: 06:00:00</div>
                            <div class="text-muted">Absen Pulang Jam: 16:00:00</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal QR Code -->
    <div class="modal fade" id="qrcodemodal" tabindex="-1" role="dialog" aria-labelledby="qrcodemodal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="qrcodemodallabel"><span class="fas fa-qrcode mr-1"></span>QR
                        Code Pegawai</h5>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <img class="img my-2" src="{{ asset(auth()->user()->qr_code_image) }}" style="width:50%;">
                    </div>
                    <dl class="row">
                        <dt class="col-sm-5">Nama Lengkap:</dt>
                        <dd class="col-sm-7">{{ auth()->user()->nama_lengkap }}</dd>
                        <dt class="col-sm-5">NPWP:</dt>
                        <dd class="col-sm-7">{{ auth()->user()->npwp }}</dd>
                        <dt class="col-sm-5">Kode Pegawai:</dt>
                        <dd class="col-sm-7">{{ auth()->user()->kode_pegawai }}</dd>
                    </dl>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
