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
        Schema::table('presensi', function (Blueprint $table) {
            $table->foreign(['id_sesi'], 'fk_sesi_presensi')->references(['id'])->on('sesi');
            $table->foreign(['id_pelatihan'], 'fk_pelatihan_presensi')->references(['id'])->on('pelatihan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('presensi', function (Blueprint $table) {
            $table->dropForeign('fk_sesi_presensi');
            $table->dropForeign('fk_pelatihan_presensi');
        });
    }
};
