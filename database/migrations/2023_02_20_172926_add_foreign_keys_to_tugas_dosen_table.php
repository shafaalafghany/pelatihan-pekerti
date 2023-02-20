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
        Schema::table('tugas_dosen', function (Blueprint $table) {
            $table->foreign(['id_dosen'], 'fk_dosen_tugas_dosen')->references(['id'])->on('dosen');
            $table->foreign(['id_tugas'], 'fk_tugas_tugas_dosen')->references(['id'])->on('tugas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tugas_dosen', function (Blueprint $table) {
            $table->dropForeign('fk_dosen_tugas_dosen');
            $table->dropForeign('fk_tugas_tugas_dosen');
        });
    }
};
