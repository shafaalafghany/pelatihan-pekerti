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
        Schema::create('sesi', function (Blueprint $table) {
            $table->comment('');
            $table->integer('id', true);
            $table->integer('id_pelatihan')->index('fk_pelatihan_sesi');
            $table->string('nama', 100);
            $table->string('keterangan', 100)->nullable();
            $table->string('tempat_pelaksanaan', 150)->nullable();
            $table->string('waktu_mulai', 0);
            $table->string('waktu_selesai', 0);
            $table->enum('jenis_pelaksanaan', ['luring', 'daring']);
            $table->string('tautan_pelaksanaan')->nullable();
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
        Schema::dropIfExists('sesi');
    }
};
