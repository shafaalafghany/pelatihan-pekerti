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
        Schema::table('nilai', function (Blueprint $table) {
            $table->foreign(['id_pelatihan'], 'fk_nilai_pelatihan')->references(['id'])->on('pelatihan');
            $table->foreign(['id_dosen'], 'fk_nilai_dosen')->references(['id'])->on('dosen');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nilai', function (Blueprint $table) {
            $table->dropForeign('fk_nilai_pelatihan');
            $table->dropForeign('fk_nilai_dosen');
        });
    }
};
