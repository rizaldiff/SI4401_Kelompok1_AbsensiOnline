<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'nama_lengkap' => 'Admin',
            'username' => 'admin',
            'password' => Hash::make('12345678'),
            'role_id' => 1,
            'umur' => 20,
            'image' => 'storage/profiles/default.jpg',
            'qr_code_image' => 'storage/qr_codes/no-qrcode.png',
            'kode_pegawai' => '293571010111',
            'instansi' => '[Ubah Nama Instansi]',
            'jabatan' => 'Test',
            'npwp' => '',
            'tgl_lahir' => '2020-10-10',
            'tempat_lahir' => 'Test',
            'jenis_kelamin' => 'Laki - Laki',
            'bagian_shift' => 1,
            'is_active' => 1,
            'qr_code_use' => 0,
            'last_login' => '2020-10-10 00:00:00',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
