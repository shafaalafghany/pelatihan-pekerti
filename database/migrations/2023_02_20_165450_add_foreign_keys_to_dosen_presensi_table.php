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
            $table->foreign(['id_sesi'], 'fk_presensi_sesi')->references(['id'])->on('sesi')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['id_user'], 'fk_user_dosen_presensi')->references(['id'])->on('dosen')->onUpdate('CASCADE')->onDelete('CASCADE');
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
            $table->dropForeign('fk_presensi_sesi');
            $table->dropForeign('fk_user_dosen_presensi');
        });
    }
};
