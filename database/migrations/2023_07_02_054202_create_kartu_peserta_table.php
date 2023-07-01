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
        Schema::create('kartu_peserta', function (Blueprint $table) {
            $table->comment('');
            $table->integer('id', true);
            $table->integer('id_dosen')->index('fk_dosen_kartu_peserta');
            $table->integer('id_pelatihan')->index('fk_pelatihan_kartu_peserta');
            $table->string('berkas_kartu_peserta')->nullable();
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
        Schema::dropIfExists('kartu_peserta');
    }
};
