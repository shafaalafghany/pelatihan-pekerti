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
        Schema::create('tugas', function (Blueprint $table) {
            $table->comment('');
            $table->integer('id', true);
            $table->integer('id_pelatihan')->index('fk_tugas_pelatihan');
            $table->integer('id_sesi')->index('fk_tugas_sesi');
            $table->string('judul', 100);
            $table->string('deskripsi', 65535);
            $table->string('batas_pengumpulan', 0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tugas');
    }
};
