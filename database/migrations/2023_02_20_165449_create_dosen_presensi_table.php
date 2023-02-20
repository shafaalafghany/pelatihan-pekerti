<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosen_presensi', function (Blueprint $table) {
            $table->comment('');
            $table->integer('id_user')->index('fk_user_dosen_presensi');
            $table->integer('id_sesi')->index('fk_presensi_sesi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dosen_presensi');
    }
};
