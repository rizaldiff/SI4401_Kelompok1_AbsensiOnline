@extends('layout.main')
@section('title', 'Export Data')
@section('content')
    <div class="container-fluid">
        <h1 class="my-4"><span class="fas fa-file mr-2"></span>Export Absensi</h1>
        <div class="row mb-4">
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <form action="{{ route('export') }}" id="cetakabsensi" target="_blank" method="post"
                            accept-charset="utf-8">
                            @csrf
                            <div class="form-group row">
                                <label for="nama_pegawai" class="col-sm-4 col-form-label">Nama Pegawai</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="nama_pegawai" name="nama_pegawai"
                                        placeholder="Nama Pegawai">
                                    <small class="muted">*Kosongkan bagian ini jika ingin menampilkan semua</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="absen_tahun" class="col-sm-4 col-form-label">Tahun Absen</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="absen_tahun" name="absen_tahun" readonly>
                                    @error('absen_tahun')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="absen_bulan" class="col-sm-4 col-form-label">Bulan Absen</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="absen_bulan" name="absen_bulan" readonly>
                                    @error('absen_bulan')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="method_export_file" class="col-sm-4 col-form-label">Metode Export Data</label>
                                <div class="col-sm-8">
                                    <select name="method_export_file" class="form-control" id="method_export_file">
                                        <option value="pdf">Files PDF</option>
                                        <option value="excel">Files Excel</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary"><span
                                            class="fas fa-file mr-1"></span>Export</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
