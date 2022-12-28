<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('role_id');
            $table->integer('umur');
            $table->string('image');
            $table->string('qr_code_image');
            $table->string('kode_pegawai')->unique();
            $table->string('instansi');
            $table->string('jabatan');
            $table->string('npwp');
            $table->date('tgl_lahir');
            $table->string('tempat_lahir');
            $table->enum('jenis_kelamin', ['Laki - Laki', 'Perempuan']);
            $table->integer('bagian_shift');
            $table->integer('is_active');
            $table->integer('qr_code_use');
            $table->timestamp('last_login');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
