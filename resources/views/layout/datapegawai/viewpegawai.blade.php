<div class="row detail">
    <div class="col-md-2 col-sm-4 col-6 p-2">
        <img class="img-thumbnail" src="{{ asset($data->image ?? 'assets/storage/profiles/default.jpg') }}"
            class="card-img" alt="Profile Image">
    </div>
    <div class="col-md-10 col-sm-8 col-6">
        <dl class="row">
            <dt class="col-sm-5">Nama Lengkap:</dt>
            <dd class="col-sm-7">{{ $data->nama_lengkap }}</dd>
            <dt class="col-sm-5">Umur:</dt>
            <dd class="col-sm-7">{{ $data->umur }}<div class="ml-1 d-inline">Tahun</div>
            </dd>
            <dt class="col-sm-5">Instansi:</dt>
            <dd class="col-sm-7 text-truncate">{{ $data->instansi }}</dd>
            <dt class="col-sm-5">Jabatan:</dt>
            <dd class="col-sm-7">{{ $data->jabatan }}</dd>
            <dt class="col-sm-5">NPWP:</dt>
            <dd class="col-sm-7">{{ $data->npwp ?: 'Tidak Ada' }}</dd>
            <dt class="col-sm-5">Tempat / Tanggal Lahir:</dt>
            <dd class="col-sm-7">{{ $data->tempat_tanggal_lahir }}</dd>
            <dt class="col-sm-5">Jenis Kelamin:</dt>
            <dd class="col-sm-7">{{ $data->jenis_kelamin }}</dd>
            <dt class="col-sm-5">Shift Bekerja:</dt>
            <dd class="col-sm-7">{!! $data->shift !!}</dd>
        </dl>
    </div>
</div>
<div class="text-center">
    <h4 class="my-2">Barcode Pegawai</h4>
    <img class="img my-2 img-rounded" src="{{ asset($data->qr_code_image ?? 'storage/qr_codes/no-qrcode.png') }}"
        style="width:15%;" alt="QR Code">
</div>
