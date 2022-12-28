<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_instansi');
            $table->string('jumbotron_lead_set');
            $table->string('nama_app_absensi')->default('Absensi Online');
            $table->string('logo_instansi');
            $table->string('timezone');
            $table->time('absen_mulai');
            $table->time('absen_mulai_to');
            $table->time('absen_pulang');
            $table->boolean('map_use');
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
        Schema::dropIfExists('settings');
    }
}
