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
        Schema::create('presensi', function (Blueprint $table) {
            $table->comment('');
            $table->integer('id', true);
            $table->integer('id_pelatihan')->index('fk_pelatihan_presensi');
            $table->integer('id_sesi')->index('fk_sesi_presensi');
            $table->string('kode_presensi', 50)->unique('kode_presensi');
            $table->string('batas_presensi', 0);
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
        Schema::dropIfExists('presensi');
    }
};
