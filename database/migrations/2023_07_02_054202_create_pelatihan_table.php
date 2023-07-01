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
        Schema::create('pelatihan', function (Blueprint $table) {
            $table->comment('');
            $table->integer('id', true);
            $table->string('nama', 150);
            $table->enum('jenis_pelatihan', ['pekerti', 'aa']);
            $table->string('mulai_pendaftaran', 0);
            $table->string('batas_pendaftaran', 0);
            $table->string('tanggal_pelaksanaan');
            $table->integer('kuota_pendaftar');
            $table->integer('jumlah_pendaftar')->default(0);
            $table->string('tautan_sertifikat')->nullable();
            $table->tinyInteger('is_active')->default(0);
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
        Schema::dropIfExists('pelatihan');
    }
};
