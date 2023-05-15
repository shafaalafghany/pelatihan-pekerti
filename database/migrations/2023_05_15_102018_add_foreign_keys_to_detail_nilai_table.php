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
        Schema::table('detail_nilai', function (Blueprint $table) {
            $table->foreign(['id_nilai'], 'fk_nilai_detail_nilai')->references(['id'])->on('nilai');
            $table->foreign(['id_tugas'], 'fk_tugas_detail_nilai')->references(['id'])->on('tugas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_nilai', function (Blueprint $table) {
            $table->dropForeign('fk_nilai_detail_nilai');
            $table->dropForeign('fk_tugas_detail_nilai');
        });
    }
};
