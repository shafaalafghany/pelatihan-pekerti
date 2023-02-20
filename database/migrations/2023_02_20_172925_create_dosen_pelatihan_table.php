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
        Schema::create('dosen_pelatihan', function (Blueprint $table) {
            $table->comment('');
            $table->integer('id_dosen')->index('fk_dosen_dosen_pelatihan');
            $table->integer('id_pelatihan')->index('fk_pelatihan_dosen_pelatihan');
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
        Schema::dropIfExists('dosen_pelatihan');
    }
};
