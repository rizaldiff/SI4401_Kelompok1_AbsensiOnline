@extends('layout.main')
@section('title', 'Dashboard Absensi')
@section('content')
    <div class="container-fluid">
        <div class="my-4 d-sm-flex align-items-center justify-content-between">
            <h1>Dashboard</h1>
            <div class="btn btn-primary" id="sync-data-dashboard"><span class="fas fa-sync-alt mr-1"></span>Refresh Data</div>
        </div>
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">
                        <h4><span class="fas fa-user-tie mr-2"></span>Jumlah Pegawai</h4>
                        <h6 class="mt-3">{{ $jmlpegawai }}<div class="d-inline ml-1">Pegawai</div>
                        </h6>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('datapegawai') }}">Lihat
                            Selengkapnya</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body">
                        <h4><span class="fas fa-user-clock mr-2"></span>Terlambat</h4>
                        <h6 class="mt-3">{{ $pegawaitelat }}<div class="d-inline ml-1">Pegawai
                            </div>
                        </h6>
                    </div>
                    <div class="card-footer small">
                        <div class="text-white">Data Hari Ini</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">
                        <h4><span class="fas fa-user-check mr-2"></span>Hadir</h4>
                        <h6 class="mt-3">{{ $pegawaimasuk }}<div class="d-inline ml-1">Pegawai</div>
                        </h6>
                    </div>
                    <div class="card-footer small">
                        <div class="text-white">Data Hari Ini</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-secondary text-white mb-4">
                    <div class="card-body">
                        <h4><span class="fas fa-clock mr-2"></span>Hari Ini</h4>
                        <div id="date-and-clock mt-3">
                            <h5 id="clocknow"></h5>
                            <h5 id="datenow"></h5>
                        </div>
                        </h6>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('index') }}">Lihat Selengkapnya</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card text-dark mb-4">
                    <div class="card-body">
                        <h4><span class="fas fa-user-tie mr-2"></span>Pegawai by Divisi</h4>
                        <canvas id="chartPegawai"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card text-dark mb-4">
                    <div class="card-body">
                        <h4><span class="fas fa-user-clock mr-2"></span>Absensi Keuangan</h4>
                        <canvas id="chartAbsensiKeuangan"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card text-dark mb-4">
                    <div class="card-body">
                        <h4><span class="fas fa-user-clock mr-2"></span>Absensi Marketing</h4>
                        <canvas id="chartAbsensiMarketing"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card text-dark mb-4">
                    <div class="card-body">
                        <h4><span class="fas fa-user-clock mr-2"></span>Absensi Sales</h4>
                        <canvas id="chartAbsensiSales"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header"><span class="fas fa-user-clock mr-1"></span>Daftar Pegawai Terlambat [Hari Ini]
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered dashboard" id="list-absensi-terlambat" width="100%"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Jam Masuk</th>
                                        <th>Nama Pegawai</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Jam Masuk</th>
                                        <th>Nama Pegawai</th>
                                        <th>Status</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header"><span class="fas fa-user-check mr-1"></span>Daftar Pegawai Hadir [Hari Ini]
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered dashboard" id="list-absensi-masuk" width="100%"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Waktu Datang</th>
                                        <th>Nama Pegawai</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Waktu Datang</th>
                                        <th>Nama Pegawai</th>
                                        <th>Status</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.1.2/chart.umd.js"
        integrity="sha512-t41WshQCxr9T3SWH3DBZoDnAT9gfVLtQS+NKO60fdAwScoB37rXtdxT/oKe986G0BFnP4mtGzXxuYpHrMoMJLA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        new Chart(
            document.getElementById('chartPegawai'), {
                type: 'doughnut',
                data: {
                    labels: [
                        'Tidak Ada',
                        'Keuangan',
                        'Marketing',
                        'Sales'
                    ],
                    datasets: [{
                        label: 'Pegawai by Divisi',
                        data: [
                            @foreach ($dataChartPegawai as $data)
                                {{ $data ?: 0 }},
                            @endforeach
                        ],
                        backgroundColor: [
                            'rgb(255, 99, 132)',
                            'rgb(54, 162, 235)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)'
                        ],
                        hoverOffset: 4
                    }]
                }
            }
        );
        new Chart(
            document.getElementById('chartAbsensiSales'), {
                type: 'doughnut',
                data: {
                    labels: [
                        'Tepat Waktu',
                        'Terlambat',
                    ],
                    datasets: [{
                        label: 'Absensi Divisi Sales',
                        data: [
                            @foreach ($dataChartAbsensiSales as $data)
                                {{ $data ?: 0 }},
                            @endforeach
                        ],
                        backgroundColor: [
                            'rgb(156, 204, 101)',
                            'rgb(236, 64, 122)',
                        ],
                        hoverOffset: 4
                    }]
                }
            }
        );
        new Chart(
            document.getElementById('chartAbsensiKeuangan'), {
                type: 'doughnut',
                data: {
                    labels: [
                        'Tepat Waktu',
                        'Terlambat',
                    ],
                    datasets: [{
                        label: 'Absensi Divisi Keuangan',
                        data: [
                            @foreach ($dataChartAbsensiKeuangan as $data)
                                {{ $data ?: 0 }},
                            @endforeach
                        ],
                        backgroundColor: [
                            'rgb(156, 204, 101)',
                            'rgb(236, 64, 122)',
                        ],
                        hoverOffset: 4
                    }]
                }
            }
        );
        new Chart(
            document.getElementById('chartAbsensiMarketing'), {
                type: 'doughnut',
                data: {
                    labels: [
                        'Tepat Waktu',
                        'Terlambat',
                    ],
                    datasets: [{
                        label: 'Absensi Divisi Marketing',
                        data: [
                            @foreach ($dataChartAbsensiMarketing as $data)
                                {{ $data ?: 0 }},
                            @endforeach
                        ],
                        backgroundColor: [
                            'rgb(156, 204, 101)',
                            'rgb(236, 64, 122)',
                        ],
                        hoverOffset: 4
                    }]
                }
            }
        );
    </script>

@endsection
