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
        Schema::table('berkas_tugas', function (Blueprint $table) {
            $table->foreign(['id_tugas'], 'fk_tugas_berkas_tugas')->references(['id'])->on('tugas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('berkas_tugas', function (Blueprint $table) {
            $table->dropForeign('fk_tugas_berkas_tugas');
        });
    }
};
