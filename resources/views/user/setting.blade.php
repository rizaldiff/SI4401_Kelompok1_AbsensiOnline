@extends('layout.main')
@section('title', 'Setting')
@section('content')
    <div class="container-fluid">
        <h1 class="my-4"><span class="fas fa-cog mr-2"></span>Setelan</h1>
        <div class="row mb-4">
            <div class="col-xl-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" id="setting-list" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" href="#setelan" role="tab"><span
                                        class="fas fa-user-cog mr-1"></span>Setelan Dasar</h1></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#gantipass" role="tab"><span
                                        class="fas fa-lock mr-1"></span>Ganti Password</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#loggeddvc" role="tab"><span
                                        class="fas fa-key mr-1"></span>Remember Me</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content mt-3">
                            <div class="tab-pane active" id="setelan" role="tabpanel">
                                <form action="#" method="post" id="settinguser" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="nama_lengkap" class="col-sm-4 col-form-label">Nama Lengkap</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                                                value="{{ $user->nama_lengkap }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="username_pegawai" class="col-sm-4 col-form-label">Username</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="username_pegawai"
                                                name="username_pegawai" value="{{ $user->username }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="jabatan_pegawai" class="col-sm-4 col-form-label">Jabatan</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="jabatan_pegawai"
                                                name="jabatan_pegawai" value="{{ $user->jabatan }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="instansi_pegawai" class="col-sm-4 col-form-label">Instansi</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="instansi_pegawai"
                                                name="instansi_pegawai" value="{{ $user->instansi }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="umur_pegawai" class="col-sm-4 col-form-label">Umur</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="umur_pegawai"
                                                    name="umur_pegawai" value="{{ $user->umur }}">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">Tahun</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="npwp_pegawai" class="col-sm-4 col-form-label">NPWP</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="npwp_pegawai" name="npwp_pegawai"
                                                value="{{ $user->npwp }}" placeholder="Tidak Ada">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-2">Pas Foto</div>
                                        <div class="col-sm-10">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <img src="{{ asset($user->image) }}" id="preview"
                                                        class="img-thumbnail">
                                                </div>
                                                <div class="col-sm-9">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="pas_foto"
                                                            name="pas_foto">
                                                        <label class="custom-file-label" for="pas_foto">Choose file. Max 2
                                                            MB</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row justify-content-end">
                                        <div class="col-sm-10">
                                            <button type="submit" class="btn btn-primary" id="usrsetting-btn"><span
                                                    class="fas fa-pen mr-1"></span>Edit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane" id="gantipass" role="tabpanel">
                                <div id="infopass"></div>
                                <form action="#" method="post" id="chgpassuser" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="pass_lama" class="col-sm-4 col-form-label">Password Lama</label>
                                        <div class="col-sm-8">
                                            <div class="input-group" id="show_hide_password">
                                                <input class="form-control py-4" name="pass_lama" id="pass_lama"
                                                    type="password" placeholder="Masukan Password Lama" />
                                                <div class="input-group-append">
                                                    <button class="input-group-text" type="button" tabindex="-1"><span
                                                            class="fas fa-eye-slash" aria-hidden="false"></span></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row" id="show_hide_password">
                                        <label for="pass_baru" class="col-sm-4 col-form-label">Password Baru</label>
                                        <div class="col-sm-8">
                                            <input type="password" class="form-control" id="password" name="password"
                                                placeholder="Masukan Password Baru">
                                        </div>
                                    </div>
                                    <div class="form-group row" id="show_hide_password">
                                        <label for="pass_baru_confirm" class="col-sm-4 col-form-label">Konfirmasi Password
                                            Baru</label>
                                        <div class="col-sm-8">
                                            <input type="password" class="form-control" id="password_confirmation"
                                                name="password_confirmation" placeholder="Konfirmasi Password Baru">
                                        </div>
                                    </div>
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary" id="chgpass-btn"><span
                                                class="fas fa-key mr-1"></span>Ubah Password</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="loggeddvc" role="tabpanel">
                                <div class="card text-white bg-dark mb-3">
                                    <div class="card-header">Perangkat Ini</div>
                                    <div class="card-body">
                                        <span
                                            class="{{ \Browser::isDesktop() ? 'fas fa-fw fa-desktop' : 'fas fa-fw fa-mobile-alt' }} fa-2x mr-1 float-left"></span>
                                        <h5 class="card-title">
                                            {{ \Browser::browserFamily() }}
                                            {{ \Browser::browserVersionMajor() }}.{{ \Browser::browserVersionMinor() }}.{{ \Browser::browserVersionPatch() }}
                                        </h5>
                                        <br>
                                        <p class="card-text">{{ \Browser::userAgent() }}</p>
                                        <button class="btn btn-primary logout">Logout</button>
                                    </div>
                                </div>
                                <h5 class="my-4"><span class="fas fa-fw fa-user-lock mr-1"></span>Remember Me Session
                                </h5>
                                <div class="card text-white bg-dark mb-3">
                                    <div class="card-header">
                                        <div class="float-left">Daftar Remember Me</div>
                                        <div class="float-right"><button class="btn btn-danger"
                                                id="clear_rememberme">Clear Remember Me</button></div>
                                    </div>
                                    <div class="card-body">
                                        <div id="remembersesslist">
                                            <!--This section for list all remember me-->
                                            @foreach ($sessions as $session)
                                                <div class="card text-white shadow bg-dark mb-3">
                                                    <div class="card-body">
                                                        <span class="fas fa-fw fa-desktop fa-2x mr-1 float-left"></span>
                                                        <h5 class="card-title">
                                                            {{ \Browser::browserFamily() }}
                                                            {{ \Browser::browserVersionMajor() }}.{{ \Browser::browserVersionMinor() }}.{{ \Browser::browserVersionPatch() }}
                                                        </h5>
                                                        <br>
                                                        <p class="card-text">{{ $session->user_agent }}</p>
                                                        <p class="card-text">
                                                            <small class="text-muted">Last access on
                                                                {{ \Carbon\Carbon::parse($session->last_activity)->translatedFormat('d F Y') }}</small>
                                                        </p>
                                                        <button type="button" class="btn btn-primary sess_rememberme"
                                                            data-sess-id="{{ $session->id }}">Hapus</button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $("#clear_rememberme").click(function(e) {
            Swal.fire({
                title: 'Hapus Semua Remember Me?',
                text: "Anda yakin ingin menghapus semua sesi remember me anda!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('ajax.clearRememberMeAll') }}",
                        beforeSend: function() {
                            swal.fire({
                                imageUrl: "{{ asset('assets/img/ajax-loader.gif') }}",
                                title: "Menghapus Semua Remember Me Anda",
                                text: "Please wait",
                                showConfirmButton: false,
                                allowOutsideClick: false
                            });
                        },
                        success: function(data) {
                            swal.fire({
                                icon: 'success',
                                title: 'Menghapus Semua Remember Me Berhasil',
                                text: 'List remember me anda telah di hapus!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $('#remembersesslist').load(location.href + " #remembersesslist");
                        }
                    });
                }
            })
            e.preventDefault();
        });
        $(".sess_rememberme").click(function(e) {
            e.preventDefault();
            var sess_id = $(e.currentTarget).attr('data-sess-id');
            if (sess_id === '') return;
            Swal.fire({
                title: 'Hapus Sesi Remember Me Ini?',
                text: "Anda yakin ingin menghapus sesi di perangkat ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: '{{ route('ajax.clearRememberMe') }}',
                        data: {
                            sess_id: sess_id
                        },
                        beforeSend: function() {
                            swal.fire({
                                imageUrl: "{{ asset('assets/img/ajax-loader.gif') }}",
                                title: "Menghapus Sesi Perangkat Ini",
                                text: "Please wait",
                                showConfirmButton: false,
                                allowOutsideClick: false
                            });
                        },
                        success: function(data) {
                            swal.fire({
                                icon: 'success',
                                title: 'Menghapus Sesi Perangkat Ini Berhasil',
                                text: 'Anda telah menghapus sesi pada perangat ini!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $(e.currentTarget).parent().remove();
                        }
                    });
                }
            })
        });
    </script>
    <script>
        $('#chgpassuser').submit(function(e) {
            e.preventDefault();
            var form = this;
            $("#chgpass-btn").html(
                    "<span class='fas fa-spinner fa-pulse' aria-hidden='true' title=''></span> Mengganti Password")
                .attr("disabled", true);
            var formdata = new FormData(form);
            $.ajax({
                url: "{{ route('ajax.changePassword') }}",
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                dataType: 'json',
                beforeSend: function() {
                    $('.text-danger').remove();
                    $("#infopass").hide();
                    swal.fire({
                        imageUrl: "{{ asset('assets/img/ajax-loader.gif') }}",
                        title: "Mengubah Password",
                        text: "Please wait",
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                },
                success: function(response) {
                    if (response.success == true) {
                        $('.text-danger').remove();
                        swal.fire({
                            icon: 'success',
                            title: 'Ubah Password Berhasil',
                            text: 'Password anda sudah diubah!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        form.reset();
                        $("#chgpass-btn").html(
                            "<span class='fas fa-key mr-1' aria-hidden='true' ></span>Ubah Password"
                        ).attr("disabled", false);
                    } else {
                        swal.close()
                        $("#infopass").html(response.infopass).show();
                        swal.fire({
                            icon: 'error',
                            title: 'Ubah Password Gagal',
                            text: 'Password anda gagal diubah!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $("#chgpass-btn").html(
                            "<span class='fas fa-key mr-1' aria-hidden='true' ></span>Ubah Password"
                        ).attr("disabled", false);
                        $.each(response.messages, function(key, value) {
                            var element = $('#' + key);
                            element.closest('div.form-group')
                                .find('.text-danger')
                                .remove();
                            if (element.parent('.input-group').length) {
                                element.parent().after('<p class="text-danger mb-0">' + value +
                                    '</p>');
                            } else {
                                element.after('<p class="text-danger mb-0">' + value +
                                    '</p>');
                            }
                        });
                    }
                },
                error: function() {
                    swal.fire("Ubah Password", "Ada Kesalahan Saat pengubahan password!", "error");
                    $("#chgpass-btn").html(
                        "<span class='fas fa-pen mr-1' aria-hidden='true' ></span>Edit").attr(
                        "disabled", false);
                }
            });

        });
    </script>
    <script>
        pas_foto.onchange = evt => {
            const [file] = pas_foto.files
            if (file) {
                preview.src = URL.createObjectURL(file)
            }
        }
        $('#settinguser').submit(function(e) {
            e.preventDefault();
            var form = this;
            $("#usrsetting-btn").html(
                "<span class='fas fa-spinner fa-pulse' aria-hidden='true' title=''></span> Mengubah Data").attr(
                "disabled", true);
            var formdata = new FormData(form);
            $.ajax({
                url: "{{ route('ajax.changeProfile') }}",
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                dataType: 'json',
                beforeSend: function() {
                    swal.fire({
                        imageUrl: "{{ asset('assets/img/ajax-loader.gif') }}",
                        title: "Mengubah Data",
                        text: "Please wait",
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                },
                success: function(response) {
                    if (response.success == true) {
                        $('.text-danger').remove();
                        swal.fire({
                            icon: 'success',
                            title: 'Ubah Profil Berhasil',
                            text: 'Profil anda sudah diubah!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        location.reload();
                        $("#usrsetting-btn").html(
                            "<span class='fas fa-pen mr-1' aria-hidden='true' ></span>Edit").attr(
                            "disabled", false);
                    } else {
                        swal.close()
                        $("#usrsetting-btn").html(
                            "<span class='fas fa-pen mr-1' aria-hidden='true' ></span>Edit").attr(
                            "disabled", false);
                        $.each(response.messages, function(key, value) {
                            var element = $('#' + key);
                            element.closest('div.form-group')
                                .find('.text-danger')
                                .remove();
                            if (element.parent('.input-group').length) {
                                element.parent().after('<p class="text-danger mb-0">' + value +
                                    '</p>');
                            } else {
                                element.after('<p class="text-danger mb-0">' + value +
                                    '</p>');
                            }
                        });
                    }
                },
                error: function() {
                    swal.fire("Mengubah Profil Gagal", "Ada Kesalahan Saat pengubahan profil!",
                        "error");
                    $("#usrsetting-btn").html(
                        "<span class='fas fa-pen mr-1' aria-hidden='true' ></span>Edit").attr(
                        "disabled", false);
                }
            });

        });
    </script>
@endsection
