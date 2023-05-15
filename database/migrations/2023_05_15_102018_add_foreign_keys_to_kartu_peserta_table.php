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
        Schema::table('kartu_peserta', function (Blueprint $table) {
            $table->foreign(['id_dosen'], 'fk_dosen_kartu_peserta')->references(['id'])->on('dosen');
            $table->foreign(['id_pelatihan'], 'fk_pelatihan_kartu_peserta')->references(['id'])->on('pelatihan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kartu_peserta', function (Blueprint $table) {
            $table->dropForeign('fk_dosen_kartu_peserta');
            $table->dropForeign('fk_pelatihan_kartu_peserta');
        });
    }
};
