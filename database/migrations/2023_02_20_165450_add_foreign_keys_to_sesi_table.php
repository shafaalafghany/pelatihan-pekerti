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
        Schema::table('sesi', function (Blueprint $table) {
            $table->foreign(['id_pelatihan'], 'fk_pelatihan_sesi')->references(['id'])->on('pelatihan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sesi', function (Blueprint $table) {
            $table->dropForeign('fk_pelatihan_sesi');
        });
    }
};
