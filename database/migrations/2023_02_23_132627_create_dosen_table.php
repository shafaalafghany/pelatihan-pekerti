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
        Schema::create('dosen', function (Blueprint $table) {
            $table->comment('');
            $table->integer('id', true);
            $table->string('email', 150)->unique('email');
            $table->string('password');
            $table->string('fullname');
            $table->tinyInteger('is_active');
            $table->string('token_verification')->nullable();
            $table->string('token_expired', 100)->nullable();
            $table->string('gelar_depan', 50)->nullable();
            $table->string('gelar_belakang', 50)->nullable();
            $table->string('berkas_ktp', 150)->nullable();
            $table->string('berkas_sk_dosen', 150)->nullable();
            $table->string('berkas_kartu_peserta', 150)->nullable();
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
        Schema::dropIfExists('dosen');
    }
};
