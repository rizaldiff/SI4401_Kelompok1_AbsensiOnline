<form action="#" id="editpegawai" enctype="multipart/form-data" method="post" accept-charset="utf-8">
    <input type="hidden" name="id_pegawai_edit" id="id_pegawai_edit" value="{{ $user->id }}">
    <div class="form-group row">
        <label for="nama_pegawai_edit" class="col-sm-4 col-form-label">Nama Pegawai</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="nama_pegawai_edit" name="nama_pegawai_edit"
                value="{{ $user->nama_lengkap }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="username_pegawai_edit" class="col-sm-4 col-form-label">Username Pegawai</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="username_pegawai_edit" name="username_pegawai_edit"
                value="{{ $user->username }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="password_pegawai_edit" class="col-sm-4 col-form-label">Password Pegawai</label>
        <div class="col-sm-8">
            <div class="input-group" id="sh_hd_pass">
                <input type="password" class="form-control" id="password_pegawai_edit" name="password_pegawai_edit">
                <div class="input-group-append">
                    <button class="input-group-text" type="button" tabindex="-1"><span class="fas fa-eye-slash"
                            aria-hidden="false"></span></button>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="kode_pegawai_edit" class="col-sm-4 col-form-label">Kode Pegawai</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="kode_pegawai_edit" name="kode_pegawai_edit"
                value="{{ $user->kode_pegawai }}"
                title="Kode telah otomatis digenerate secara acak pada saat penambahan pegawai" readonly>
        </div>
    </div>
    <div class="form-group row">
        <label for="jabatan_pegawai_edit" class="col-sm-4 col-form-label">Jabatan</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="jabatan_pegawai_edit" name="jabatan_pegawai_edit"
                value="{{ $user->jabatan }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="instansi_pegawai_edit" class="col-sm-4 col-form-label">Instansi</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="instansi_pegawai_edit" name="instansi_pegawai_edit"
                value="{{ config('settings.nama_instansi') ?? '[Nama Instansi Belum Disetting]' }}"
                data-toggle="tooltip" data-placement="top"
                title="Untuk mengubah nama instansi ini silakan buka pada bagian setting aplikasi" readonly>
        </div>
    </div>
    <div class="form-group row">
        <label for="npwp_pegawai_edit" class="col-sm-4 col-form-label">NPWP</label>
        <div class="col-sm-8">
            <div class="input-group">
                <input type="text" class="form-control" id="npwp_pegawai_edit" name="npwp_pegawai_edit"
                    value="{{ $user->npwp }}">
                <div class="input-group-append">
                    <div class="input-group-text">Opsional</div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="umur_pegawai_edit" class="col-sm-4 col-form-label">Umur</label>
        <div class="col-sm-8">
            <div class="input-group">
                <input type="text" class="form-control" id="umur_pegawai_edit" name="umur_pegawai_edit"
                    value="{{ $user->umur }}" maxlength="2">
                <div class="input-group-append">
                    <div class="input-group-text">Tahun</div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="tempat_lahir_pegawai_edit" class="col-sm-4 col-form-label">Tempat Lahir</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="tempat_lahir_pegawai_edit"
                name="tempat_lahir_pegawai_edit" value="{{ $user->tempat_lahir }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="tgl_lahir_pegawai_edit" class="col-sm-4 col-form-label">Tanggal Lahir</label>
        <div class="col-sm-8">
            <input type="date" class="form-control" id="tgl_lahir_pegawai_edit" name="tgl_lahir_pegawai_edit"
                value="{{ $user->tgl_lahir }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="role_pegawai_edit" class="col-sm-4 col-form-label">Role Akun</label>
        <div class="col-sm-8">
            <select name="role_pegawai_edit" class="form-control" id="role_pegawai_edit">
                <option value="">Select Role</option>
                <option value="1">Administrator</option>
                <option value="2">Pegawai</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="jenis_kelamin_pegawai" class="col-sm-4 col-form-label">Jenis Kelamin</label>
        <div class="col-sm-8">
            <div class="form-check form-check-inline">
                <input type="radio" name="jenis_kelamin_pegawai_edit" value="Laki - Laki"
                    id="jenis_kelamin_pegawai_edit" class="form-check-input" />
                <label class="form-check-label" for="jenis_kelamin_pegawai_edit1">Laki - Laki</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" name="jenis_kelamin_pegawai_edit" value="Perempuan"
                    class="form-check-input" />
                <label class="form-check-label" for="jenis_kelamin_pegawai_edit2">Perempuan</label>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="shift_pegawai_edit" class="col-sm-4 col-form-label">Shift Bagian</label>
        <div class="col-sm-8">
            <div class="form-check form-check-inline">
                <input type="radio" name="shift_pegawai_edit" value="1" id="shift_pegawai_edit"
                    class="form-check-input" />
                <label class="form-check-label" for="shift_pegawai_edit1">Full Time</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" name="shift_pegawai_edit" value="2" class="form-check-input" />
                <label class="form-check-label" for="shift_pegawai_edit2">Part Time</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" name="shift_pegawai_edit" value="3" class="form-check-input" />
                <label class="form-check-label" for="shift_pegawai_edit3">Shift</label>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="verifikasi_pegawai_edit" class="col-sm-4 col-form-label">Verifikasi Pegawai</label>
        <div class="col-sm-8">
            <div class="form-check form-check-inline">
                <input type="radio" name="verifikasi_pegawai_edit" value="0" id="verifikasi_pegawai_edit"
                    class="form-check-input" />
                <label class="form-check-label" for="verifikasi_pegawai_edit1">Belum Terverifikasi</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" name="verifikasi_pegawai_edit" value="1" class="form-check-input" />
                <label class="form-check-label" for="verifikasi_pegawai_edit2">Terverifikasi</label>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="barcode_pegawai" class="col-sm-4 col-form-label">Buat Barcode Pegawai</label>
        <div class="col-sm-8">
            <div class="custom-control custom-checkbox"><input type="checkbox" name="barcode_pegawai_edit"
                    value="1" id="barcode_pegawai_edit" class="custom-control-input" />
                <label class="custom-control-label" for="barcode_pegawai_edit">Dengan Barcode</label>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-2">Pas Foto Pegawai</div>
        <div class="col-sm-10">
            <div class="row">
                <div class="col-sm-3">
                    <img src="{{ asset($user->image ?? 'storage/profiles/default.jpg') }}" class="img-thumbnail">
                </div>
                <div class="col-sm-9">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input edit-pas-pegawai" id="foto_pegawai_edit"
                            name="foto_pegawai_edit">
                        <label class="custom-file-label edit-pas-pegawai-label" for="foto_pegawai_edit">Choose
                            file.
                            Max 2
                            MB</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="my-2" id="info-edit"></div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><span
                class="fas fa-times mr-1"></span>Batal</button>
        <button type="submit" class="btn btn-primary" id="editpgw-btn"><span
                class="fas fa-pen mr-1"></span>Edit</button>
    </div>
</form>

<script>
    $("#sh_hd_pass button").on('click', function(event) {
        event.preventDefault();
        if ($('#sh_hd_pass input').attr("type") == "text") {
            $('#sh_hd_pass input').attr('type', 'password');
            $('#sh_hd_pass span').addClass("fa-eye-slash");
            $('#sh_hd_pass span').removeClass("fa-eye");
        } else if ($('#sh_hd_pass input').attr("type") == "password") {
            $('#sh_hd_pass input').attr('type', 'text');
            $('#sh_hd_pass span').removeClass("fa-eye-slash");
            $('#sh_hd_pass span').addClass("fa-eye");
        }
    });

    $('.edit-pas-pegawai').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.edit-pas-pegawai-label').addClass("selected").html(fileName);
    });

    $('#role_pegawai_edit').val({{ $user->role_id }});

    $('input[name=jenis_kelamin_pegawai_edit][value="{{ $user->jenis_kelamin }}"]').prop('checked', true);

    $('input[name=shift_pegawai_edit][value={{ $user->bagian_shift }}]').prop('checked', true);

    $('input[name=verifikasi_pegawai_edit][value={{ $user->is_active }}]').prop('checked', true);

    @if ($user->qr_code_use == 1)
        $('#barcode_pegawai_edit').prop('checked', true);
    @endif
</script>
