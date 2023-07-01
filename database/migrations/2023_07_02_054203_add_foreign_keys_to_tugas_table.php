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
        Schema::table('tugas', function (Blueprint $table) {
            $table->foreign(['id_sesi'], 'fk_tugas_sesi')->references(['id'])->on('sesi');
            $table->foreign(['id_pelatihan'], 'fk_tugas_pelatihan')->references(['id'])->on('pelatihan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tugas', function (Blueprint $table) {
            $table->dropForeign('fk_tugas_sesi');
            $table->dropForeign('fk_tugas_pelatihan');
        });
    }
};
