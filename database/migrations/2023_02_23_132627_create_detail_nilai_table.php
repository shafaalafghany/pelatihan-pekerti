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
        Schema::create('detail_nilai', function (Blueprint $table) {
            $table->comment('');
            $table->integer('id', true);
            $table->integer('id_nilai')->index('fk_nilai_detail_nilai');
            $table->integer('id_tugas')->nullable()->index('fk_tugas_detail_nilai');
            $table->string('nama_nilai', 50);
            $table->integer('nilai');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_nilai');
    }
};
