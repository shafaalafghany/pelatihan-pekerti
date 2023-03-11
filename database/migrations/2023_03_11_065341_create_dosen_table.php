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
            $table->string('token_verification')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('nik')->nullable();
            $table->string('nidn_nidk')->nullable();
            $table->string('gelar_depan', 50)->nullable();
            $table->string('gelar_belakang', 50)->nullable();
            $table->string('berkas_ktp', 150)->nullable();
            $table->string('berkas_sk_dosen', 150)->nullable();
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
