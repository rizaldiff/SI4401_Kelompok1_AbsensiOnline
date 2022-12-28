<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Setting::create([
            'id' => 1,
            'nama_instansi' => '[Ubah Nama Instansi]',
            'jumbotron_lead_set' => '[Ubah Text Berjalan Halaman Depan]',
            'nama_app_absensi' => 'Absensi Online',
            'logo_instansi' => 'storage/settings/default-logo.png',
            'timezone' => 'Asia/Jakarta',
            'absen_mulai' => '06:00:00',
            'absen_mulai_to' => '11:00:00',
            'absen_pulang' => '16:00:00',
            'map_use' => 1,
        ]);
    }
}
