<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" type="image/png" href="{{ asset(config('settings.logo_instansi')) }}">
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', config('settings.nama_app_absensi'))</title>
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/jonthornton-jquery-timepicker/jquery.timepicker.min.css') }}"
        rel="stylesheet" />
    <link href="{{ asset('assets/vendor/bootstrap-toggle-master/css/bootstrap4-toggle.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/leaflet/leaflet.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/vendor/leaflet/leaflet.js') }}"></script>

</head>

<body class="sb-nav-fixed">
    @include('layout.partials.navbar')
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            @include('layout.partials.sidebar')
        </div>
        <div id="layoutSidenav_content">
            <main>
                @yield('content')
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; 2022<a href="{{ route('index') }}"
                                class="ml-1">{{ config('settings.nama_app_absensi') }}</a>
                        </div>
                        <div class="text-muted">
                            Page rendered in <strong>{{ number_format(microtime(true) - LARAVEL_START, 4) }}</strong>
                            seconds.
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/sb-admin-js.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-toggle-master/js/bootstrap4-toggle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jonthornton-jquery-timepicker/jquery.timepicker.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-datepicker/locales/bootstrap-datepicker.id.min.js') }}" charset="UTF-8">
    </script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#yearpicker,#absen_tahun').datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            orientation: "bottom auto"
        });

        $('body').on('shown.bs.modal', function(e) {
            setTimeout(function() {
                map.invalidateSize()
            }, 500);
        })

        $('#setting-list a').on('click', function(e) {
            e.preventDefault()
            $(this).tab('show')
        })

        $('#absen_bulan').datepicker({
            format: "MM",
            minViewMode: 'months',
            maxViewMode: 'months',
            startView: 'months',
            language: "id",
            orientation: "bottom auto"
        });

        $(document).ready(function() {
            $('#datatables').DataTable();
        });

        $(document).ready(function() {
            $('table.dashboard').DataTable();
        });
    </script>
    <script>
        function load_process() {
            swal.fire({
                imageUrl: "{{ asset('assets/img/ajax-loader.gif') }}",
                title: "Refresh Data",
                text: "Please wait",
                showConfirmButton: false,
                allowOutsideClick: false,
                timer: 1500
            });
        }

        $(".logout").click(function(event) {
            $.ajax({
                type: "POST",
                url: "{{ route('logout') }}",
                beforeSend: function() {
                    swal.fire({
                        imageUrl: "{{ asset('assets/img/ajax-loader.gif') }}",
                        title: "Logging Out",
                        text: "Please wait",
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                },
                success: function(data) {
                    swal.fire({
                        icon: 'success',
                        title: 'Logout',
                        text: 'Anda Telah Keluar!',
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                    location.reload();
                }
            });
            event.preventDefault();
        });

        @if (config('settings.map_use') == 1)
            let maps_absen = "searching...";
            if (document.getElementById("maps-absen")) {
                window.onload = function() {
                    var popup = L.popup();
                    var geolocationMap = L.map("maps-absen", {
                        center: [40.731701, -73.993411],
                        zoom: 15,
                    });

                    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                    }).addTo(geolocationMap);

                    function geolocationErrorOccurred(geolocationSupported, popup, latLng) {
                        popup.setLatLng(latLng);
                        popup.setContent(
                            geolocationSupported ?
                            "<b>Error:</b> The Geolocation service failed." :
                            "<b>Error:</b> This browser doesn't support geolocation."
                        );
                        popup.openOn(geolocationMap);
                    }

                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(
                            function(position) {
                                var latLng = {
                                    lat: position.coords.latitude,
                                    lng: position.coords.longitude,
                                };

                                var marker = L.marker(latLng).addTo(geolocationMap);
                                maps_absen = position.coords.latitude + ", " + position.coords.longitude;
                                geolocationMap.setView(latLng);
                            },
                            function() {
                                geolocationErrorOccurred(true, popup, geolocationMap.getCenter());
                                maps_absen = 'No Location';
                            }
                        );
                    } else {
                        //No browser support geolocation service
                        geolocationErrorOccurred(false, popup, geolocationMap.getCenter());
                        maps_absen = 'No Location';
                    }
                };
            }
        @else
            maps_absen = 'No Location';
        @endif

        $("#btn-absensi").click(function(e) {

            e.preventDefault(); // avoid to execute the actual submit of the form.

            let ket_absen = $('#ket_absen').val();

            $.ajax({
                type: "POST",
                url: '{{ route('ajax.absenajax') }}',
                data: {
                    maps_absen: maps_absen,
                    ket_absen: ket_absen
                }, // serializes the form's elements.
                dataType: 'json',
                beforeSend: function() {
                    swal.fire({
                        imageUrl: "{{ asset('assets/img/ajax-loader.gif') }}",
                        title: "Proses Absensi",
                        text: "Please wait",
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                },
                success: function(response) {
                    if (response.success == true) {
                        swal.fire({
                            icon: 'success',
                            title: 'Absen Sukses',
                            text: 'Anda Telah Absen!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#func-absensi').load(location.href + " #func-absensi");
                    } else {
                        $("#infoabsensi").html(response.msgabsen).show().delay(3000).fadeOut();
                        swal.close()
                    }
                },
                error: function() {
                    swal.fire("Absen Gagal", "Ada Kesalahan Saat Absen!", "error");
                }
            });


        });
    </script>
    <!--Bagian CRUD Absen User-->
    <script>
        $("#listabsenku").on('click', '.detail-absen', function(e) {
            e.preventDefault();
            var absen_id = $(e.currentTarget).attr('data-absen-id');
            if (absen_id === '') return;
            $.ajax({
                type: "POST",
                url: '{{ route('ajax.getDetailAbsensi') }}',
                data: {
                    absen_id: absen_id
                },
                beforeSend: function() {
                    swal.fire({
                        imageUrl: "{{ asset('assets/img/ajax-loader.gif') }}",
                        title: "Mempersiapkan Preview Absensi",
                        text: "Please wait",
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                },
                success: function(data) {
                    swal.close();
                    $('#viewabsensimodal').modal('show');
                    $('#viewdataabsensi').html(data);

                },
                error: function() {
                    swal.fire("Preview Absensi Gagal", "Ada Kesalahan Saat menampilkan data absensi!",
                        "error");
                }
            });
        });
    </script>
    <script>
        $("#refresh-tabel-absensi").click(function(e) {
            e.preventDefault();
            load_process();
            $('#listabsenku').DataTable().ajax.reload();
        });

        $('#listabsenku').DataTable({
            "ajax": {
                url: "{{ route('ajax.getAbsensikuDt') }}",
                type: 'get',
                async: true,
                "processing": true,
                "serverSide": true,
                dataType: 'json',
                "bDestroy": true
            },
            rowCallback: function(row, data, iDisplayIndex) {
                $('td:eq(0)', row).html();
            }
        });
    </script>
    <!-- Bagian Dashboard Admin-->
    <script>
        $("#sync-data-dashboard").click(function(e) {
            e.preventDefault();
            load_process();
            $('#list-absensi-masuk,#list-absensi-terlambat').DataTable().ajax.reload();
        });

        $("#refresh-tabel-absensi").click(function(e) {
            e.preventDefault();
            load_process();
            $('#list-absensi-all').DataTable().ajax.reload();
        });

        $("#refresh-tabel-pegawai").click(function(e) {
            e.preventDefault();
            load_process();
            $('#datapegawai').DataTable().ajax.reload();
        });
    </script>
    <script>
        $('#list-absensi-masuk').DataTable({
            "ajax": {
                url: "{{ route('ajax.getPegawaiMasukDt') }}",
                type: 'get',
                async: true,
                "processing": true,
                "serverSide": true,
                dataType: 'json',
                "bDestroy": true
            },
            rowCallback: function(row, data, iDisplayIndex) {
                $('td:eq(0)', row).html();
            }
        });
        $('#list-absensi-terlambat').DataTable({
            "ajax": {
                url: "{{ route('ajax.getPegawaiTerlambatDt') }}",
                type: 'get',
                async: true,
                "processing": true,
                "serverSide": true,
                dataType: 'json',
                "bDestroy": true
            },
            rowCallback: function(row, data, iDisplayIndex) {
                $('td:eq(0)', row).html();
            }
        });
    </script>
    <script>
        var divisi = $('#filter-divisi').val();
        $("#filter-divisi").change(function(e) {
            e.preventDefault();
            load_process();
            divisi = $('#filter-divisi').val();
            $('#list-absensi-all').DataTable().ajax.url('/ajax/absensi?divisi=' + divisi).load();
        });
        $('#list-absensi-all').DataTable({
            "ajax": {
                url: "{{ route('ajax.absensi') }}",
                type: 'get',
                async: true,
                cache: false,
                "processing": true,
                "serverSide": true,
                dataType: 'json',
                "bDestroy": true
            },
            rowCallback: function(row, data, iDisplayIndex) {
                $('td:eq(0)', row).html();
            }
        });
    </script>
    <!--CRUD Absen-->
    <script>
        $("#clear-absensi").on('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Hapus Semua Absen?',
                text: "Anda yakin ingin menghapus absensi ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: '{{ route('ajax.hapusSemuaAbsensi') }}',
                        beforeSend: function() {
                            swal.fire({
                                imageUrl: "{{ asset('assets/img/ajax-loader.gif') }}",
                                title: "Menghapus Semua Absen",
                                text: "Please wait",
                                showConfirmButton: false,
                                allowOutsideClick: false
                            });
                        },
                        success: function(data) {
                            swal.fire({
                                icon: 'success',
                                title: 'Menghapus Semua Absen Berhasil',
                                text: 'Absen telah dihapus!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $('#list-absensi-all').DataTable().ajax.reload();
                        },
                        error: function() {
                            swal.fire("Hapus Absensi Gagal",
                                "Ada Kesalahan Saat menghapus semua absensi!", "error");
                        }
                    });
                }
            })
        });


        $("#list-absensi-all").on('click', '.delete-absen', function(e) {
            e.preventDefault();
            var absen_id = $(e.currentTarget).attr('data-absen-id');
            if (absen_id === '') return;
            Swal.fire({
                title: 'Hapus Absen Ini?',
                text: "Anda yakin ingin menghapus absensi ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: '{{ route('ajax.hapusAbsensi') }}',
                        data: {
                            absen_id: absen_id
                        },
                        beforeSend: function() {
                            swal.fire({
                                imageUrl: "{{ asset('assets/img/ajax-loader.gif') }}",
                                title: "Menghapus Absen",
                                text: "Please wait",
                                showConfirmButton: false,
                                allowOutsideClick: false
                            });
                        },
                        success: function(data) {
                            swal.fire({
                                icon: 'success',
                                title: 'Menghapus Absen Berhasil',
                                text: 'Absen telah dihapus!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $('#list-absensi-all').DataTable().ajax.reload();
                        },
                        error: function() {
                            swal.fire("Hapus Absensi Gagal",
                                "Ada Kesalahan Saat menghapus absensi!", "error");
                        }
                    });
                }
            })
        });

        $("#list-absensi-all").on('click', '.detail-absen', function(e) {
            e.preventDefault();
            var absen_id = $(e.currentTarget).attr('data-absen-id');
            if (absen_id === '') return;
            $.ajax({
                type: "POST",
                url: '{{ route('ajax.getDetailAbsensi') }}',
                data: {
                    absen_id: absen_id
                },
                beforeSend: function() {
                    swal.fire({
                        imageUrl: "{{ asset('assets/img/ajax-loader.gif') }}",
                        title: "Mempersiapkan Preview Absensi",
                        text: "Please wait",
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                },
                success: function(data) {
                    swal.close();
                    $('#viewabsensimodal').modal('show');
                    $('#viewdataabsensi').html(data);

                },
                error: function() {
                    swal.fire("Preview Absensi Gagal", "Ada Kesalahan Saat menampilkan data absensi!",
                        "error");
                }
            });
        });

        $("#list-absensi-all").on('click', '.print-absen', function(e) {
            e.preventDefault();
            var absen_id = $(e.currentTarget).attr('data-absen-id');
            if (absen_id === '') return;
            $('#printabsensimodal').on('show.bs.modal', function(e) {
                $(this).find('.btn-print-direct').attr('href',
                    '{{ route('ajax.cetak') }}?id_absen=' + absen_id + '');
            });
            $("#printdataabsensi").html(
                '<object type="application/pdf" data="{{ route('ajax.cetak') }}?id_absen=' +
                absen_id +
                '" height="850" style="width: 100%; display: block;">Your browser does not support object tag</object>'
            );
        });
    </script>
    <!--CRUD Pegawai-->
    <script>
        $('#datapegawai').DataTable({
            "ajax": {
                url: "{{ route('ajax.getPegawaiDt') }}",
                type: 'get',
                async: true,
                "processing": true,
                "serverSide": true,
                dataType: 'json',
                "bDestroy": true
            },
            rowCallback: function(row, data, iDisplayIndex) {
                $('td:eq(0)', row).html();
            }
        });

        $('#addpegawai').submit(function(e) {
            e.preventDefault();
            var form = this;
            $("#addpgw-btn").html(
                    "<span class='fas fa-spinner fa-pulse' aria-hidden='true' title=''></span> Proses Penambahan")
                .attr("disabled", true);
            var formdata = new FormData(form);
            $.ajax({
                url: "{{ route('ajax.storePegawai') }}",
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                dataType: 'json',
                beforeSend: function() {
                    $("#info-data").hide();
                    swal.fire({
                        imageUrl: "{{ asset('assets/img/ajax-loader.gif') }}",
                        title: "Menambahkan Pegawai",
                        text: "Please wait",
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                },
                success: function(response) {
                    $("#info-data").html(response.messages).attr("disabled", false).show();
                    if (response.success == true) {
                        $('.text-danger').remove();
                        swal.fire({
                            icon: 'success',
                            title: 'Penambahan Pegawai Berhasil',
                            text: 'Penambahan pegawai sudah berhasil !',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#datapegawai').DataTable().ajax.reload();
                        $('#addpegawaimodal').modal('hide');
                        form.reset();
                        $("#addpgw-btn").html(
                                "<span class='fas fa-plus mr-1' aria-hidden='true' ></span>Simpan")
                            .attr("disabled", false);
                    } else {
                        swal.close()
                        $("#addpgw-btn").html(
                                "<span class='fas fa-plus mr-1' aria-hidden='true' ></span>Simpan")
                            .attr("disabled", false);
                    }
                },
                error: function() {
                    swal.fire("Penambahan Pegawai Gagal", "Ada Kesalahan Saat penambahan pegawai!",
                        "error");
                    $("#addpgw-btn").html(
                        "<span class='fas fa-pen mr-1' aria-hidden='true' ></span>Edit").attr(
                        "disabled", false);
                }
            });

        });

        $("#datapegawai").on('click', '.delete-pegawai', function(e) {
            e.preventDefault();
            var pgw_id = $(e.currentTarget).attr('data-pegawai-id');
            if (pgw_id === '') return;
            Swal.fire({
                title: 'Hapus User Ini?',
                text: "Anda yakin ingin menghapus user ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: '{{ route('ajax.deletePegawai') }}',
                        data: {
                            pgw_id: pgw_id
                        },
                        beforeSend: function() {
                            swal.fire({
                                imageUrl: "{{ asset('assets/img/ajax-loader.gif') }}",
                                title: "Menghapus User",
                                text: "Please wait",
                                showConfirmButton: false,
                                allowOutsideClick: false
                            });
                        },
                        success: function(data) {
                            if (data.success == false) {
                                swal.fire({
                                    icon: 'error',
                                    title: 'Menghapus User Gagal',
                                    text: data.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            } else {
                                swal.fire({
                                    icon: 'success',
                                    title: 'Menghapus User Berhasil',
                                    text: data.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                $('#datapegawai').DataTable().ajax.reload();
                            }
                        },
                        error: function() {
                            swal.fire("Penghapusan Pegawai Gagal",
                                "Ada Kesalahan Saat menghapus pegawai!", "error");
                        }
                    });
                }
            })
        });

        $("#datapegawai").on('click', '.activate-pegawai', function(e) {
            e.preventDefault();
            var pgw_id = $(e.currentTarget).attr('data-pegawai-id');
            if (pgw_id === '') return;
            $.ajax({
                type: "POST",
                url: '{{ route('ajax.actPegawai') }}',
                data: {
                    pgw_id: pgw_id
                },
                dataType: 'json',
                beforeSend: function() {
                    swal.fire({
                        imageUrl: "{{ asset('assets/img/ajax-loader.gif') }}",
                        title: "Aktivasi User",
                        text: "Please wait",
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                },
                success: function(data) {
                    if (data.success) {
                        swal.fire({
                            icon: 'success',
                            title: 'Aktivasi User Berhasil',
                            text: 'Anda telah mengaktifkan user!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#datapegawai').DataTable().ajax.reload();
                    } else {
                        swal.fire({
                            icon: 'error',
                            title: 'User Sudah Diaktivasi',
                            text: 'User ini sudah diaktivasi!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#datapegawai').DataTable().ajax.reload();
                    }
                },
                error: function() {
                    swal.fire("Aktivasi Pegawai Gagal", "Ada Kesalahan Saat aktivasi pegawai!",
                        "error");
                }
            });
        });

        $("#datapegawai").on('click', '.view-pegawai', function(e) {
            e.preventDefault();
            var pgw_id = $(e.currentTarget).attr('data-pegawai-id');
            if (pgw_id === '') return;
            $.ajax({
                type: "POST",
                url: '{{ route('ajax.getDetailPegawai') }}',
                data: {
                    pgw_id: pgw_id
                },
                beforeSend: function() {
                    swal.fire({
                        imageUrl: "{{ asset('assets/img/ajax-loader.gif') }}",
                        title: "Mempersiapkan Preview User",
                        text: "Please wait",
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                },
                success: function(data) {
                    swal.close();
                    $('#viewpegawaimodal').modal('show');
                    $('#viewdatapegawai').html(data);

                },
                error: function() {
                    swal.fire("Preview Pegawai Gagal", "Ada Kesalahan Saat menampilkan data pegawai!",
                        "error");
                }
            });
        });

        $("#datapegawai").on('click', '.edit-pegawai', function(e) {
            e.preventDefault();
            var pgw_id = $(e.currentTarget).attr('data-pegawai-id');
            if (pgw_id === '') return;
            $.ajax({
                type: "POST",
                url: '{{ route('ajax.editPegawai') }}',
                data: {
                    pgw_id: pgw_id
                },
                beforeSend: function() {
                    swal.fire({
                        imageUrl: "{{ asset('assets/img/ajax-loader.gif') }}",
                        title: "Mempersiapkan Edit User",
                        text: "Please wait",
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                },
                success: function(data) {
                    swal.close();
                    $('#editpegawaimodal').modal('show');
                    $('#editdatapegawai').html(data);

                    $('#editpegawai').submit(function(e) {
                        e.preventDefault();
                        var form = this;
                        $("#editpgw-btn").html(
                            "<span class='fas fa-spinner fa-pulse' aria-hidden='true' title=''></span> Menyimpan"
                        ).attr("disabled", true);
                        var formdata = new FormData(form);
                        $.ajax({
                            url: "{{ route('ajax.updatePegawai') }}",
                            type: 'POST',
                            data: formdata,
                            processData: false,
                            contentType: false,
                            cache: false,
                            enctype: 'multipart/form-data',
                            dataType: 'json',
                            beforeSend: function() {
                                swal.fire({
                                    imageUrl: "{{ asset('assets/img/ajax-loader.gif') }}",
                                    title: "Menyimpan Data Pegawai",
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
                                        title: 'Edit Pegawai Berhasil',
                                        text: 'Edit pegawai sudah berhasil !',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    $('#datapegawai').DataTable().ajax.reload();
                                    $('#editpegawaimodal').modal('hide');
                                    form.reset();
                                    $("#editpgw-btn").html(
                                        "<span class='fas fa-pen mr-1' aria-hidden='true' ></span>Edit"
                                    ).attr("disabled", false);
                                } else {
                                    swal.close()
                                    $("#editpgw-btn").html(
                                        "<span class='fas fa-pen mr-1' aria-hidden='true' ></span>Edit"
                                    ).attr("disabled", false);
                                    $("#info-edit").html(response.messages);
                                }
                            },
                            error: function() {
                                swal.fire("Edit Pegawai Gagal",
                                    "Ada Kesalahan Saat pengeditan pegawai!",
                                    "error");
                                $("#editpgw-btn").html(
                                    "<span class='fas fa-pen mr-1' aria-hidden='true' ></span>Edit"
                                ).attr("disabled", false);
                            }
                        });

                    });
                },
                error: function() {
                    swal.fire("Edit Pegawai Gagal", "Ada Kesalahan Saat pengeditan pegawai!", "error");
                }
            });
        });
    </script>
    <!-- Bagian Setting Aplikasi-->
    <script>
        $("#absen_mulai,#absen_sampai, #absen_pulang_sampai").timepicker({
            'timeFormat': 'H:i:s'
        });
        $('#setTimebtn').on('click', function() {
            $('#absen_mulai').timepicker('setTime', new Date());
        });

        $("#resetsettingapp").click(function(event) {
            Swal.fire({
                title: 'Reset Settings App',
                text: "Anda yakin ingin reset ulang settingan ini ke awal!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Reset!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('ajax.initSettings') }}",
                        beforeSend: function() {
                            swal.fire({
                                imageUrl: "{{ asset('assets/img/ajax-loader.gif') }}",
                                title: "Resetting Setting App",
                                text: "Please wait",
                                showConfirmButton: false,
                                allowOutsideClick: false
                            });
                        },
                        success: function(data) {
                            swal.fire("Reset!", "Settingan Telah Direset.", "success");
                            location.reload();
                        }
                    });
                }
            })
            event.preventDefault();
        });

        $("#initsettingapp").click(function(event) {
            $.ajax({
                type: "POST",
                url: "http://absendigital.localdomain/ajax/initsettingapp?type=2",
                beforeSend: function() {
                    swal.fire({
                        imageUrl: "{{ asset('assets/img/ajax-loader.gif') }}",
                        title: "Initializing Setting App",
                        text: "Please wait",
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                },
                success: function(data) {
                    swal.fire("Initialize Setting App", "Initialisasi Setting Aplikasi Sukses!",
                        "success");
                    location.reload();
                }
            });
            event.preventDefault();
        });

        $('#settingapp').submit(function(e) {
            e.preventDefault();
            $("#settingapp-btn").html(
                "<span class='fas fa-spinner fa-pulse' aria-hidden='true' title=''></span> Saving").attr(
                "disabled", true);
            var formdata = new FormData(this);
            $.ajax({
                url: "{{ route('ajax.updateSettings') }}",
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                dataType: 'json',
                beforeSend: function() {
                    swal.fire({
                        imageUrl: "{{ asset('assets/img/ajax-loader.gif') }}",
                        title: "Editing Setting App",
                        text: "Please wait",
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                },
                success: function(response) {
                    if (response.success == true) {
                        $('.text-danger').remove();
                        swal.fire("Edit Setelan", "Edit Setelan Berhasil!", "success");
                        $("#settingapp-btn").html(
                            "<span class='fas fa-pen mr-1' aria-hidden='true' ></span>Edit").attr(
                            "disabled", false);
                        location.reload();
                    } else {
                        swal.close()
                        swal.fire({
                            icon: 'error',
                            title: "Edit Setelan",
                            text: "Edit Setelan Gagal!",
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            timer: 1500
                        });
                        $("#settingapp-btn").html(
                            "<span class='fas fa-pen mr-1' aria-hidden='true' ></span>Edit").attr(
                            "disabled", false);
                        $.each(response.messages, function(key, value) {
                            var element = $('#' + key);
                            element.closest('div.form-group')
                                .find('.text-danger')
                                .remove();
                            if (element.parent('.input-group').length) {
                                element.parent().after(value);
                            } else {
                                element.after('<p class="text-danger mb-0">' + value +
                                    '</p>');
                            }
                        });
                    }
                },
                error: function() {
                    swal.fire("Setelan Aplikasi Gagal", "Ada Kesalahan Saat Edit Setelan!", "error");
                    $("#settingapp-btn").html(
                        "<span class='fas fa-pen mr-1' aria-hidden='true' ></span>Edit").attr(
                        "disabled", false);
                }
            });

        });
    </script>
    @yield('script')
</body>

</html>
