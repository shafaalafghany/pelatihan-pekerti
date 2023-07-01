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
        Schema::create('sertifikat_tandatangan', function (Blueprint $table) {
            $table->comment('');
            $table->integer('id', true);
            $table->integer('id_pelatihan')->index('fk_sertifikat_ttd_pelatihan');
            $table->integer('id_dosen')->index('fk_sertifikat_ttd_dosen');
            $table->string('nama_berkas');
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
        Schema::dropIfExists('sertifikat_tandatangan');
    }
};
