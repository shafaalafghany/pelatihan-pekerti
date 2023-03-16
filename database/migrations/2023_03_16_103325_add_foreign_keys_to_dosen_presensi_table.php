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
        Schema::table('dosen_presensi', function (Blueprint $table) {
            $table->foreign(['id_sesi'], 'fk_dosen_presensi_sesi')->references(['id'])->on('sesi');
            $table->foreign(['id_dosen'], 'fk_dosen_dosen_presensi')->references(['id'])->on('dosen');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dosen_presensi', function (Blueprint $table) {
            $table->dropForeign('fk_dosen_presensi_sesi');
            $table->dropForeign('fk_dosen_dosen_presensi');
        });
    }
};
