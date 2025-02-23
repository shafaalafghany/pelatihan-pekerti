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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->comment('');
            $table->integer('id', true);
            $table->integer('id_dosen')->index('fk_dosen_pembayaran');
            $table->integer('id_pelatihan')->index('fk_pelatihan_pembayaran');
            $table->string('invoice', 50);
            $table->string('kode_pembayaran')->nullable();
            $table->tinyInteger('status');
            $table->string('snap_token')->nullable();
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
        Schema::dropIfExists('pembayaran');
    }
};
