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
        Schema::create('tugas_dosen', function (Blueprint $table) {
            $table->comment('');
            $table->integer('id', true);
            $table->integer('id_tugas')->index('fk_tugas_tugas_dosen');
            $table->integer('id_dosen')->index('fk_dosen_tugas_dosen');
            $table->string('berkas_tugas', 150)->nullable();
            $table->string('online_text', 65535)->nullable();
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
        Schema::dropIfExists('tugas_dosen');
    }
};
