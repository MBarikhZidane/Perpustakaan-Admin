<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('raks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('idz', 20);
            $table->string('kode_rak', 20)->unique();
            $table->string('nama_rak', 50);
            $table->string('lokasi_id', 20);
            $table->timestamps();

            $table->foreign('lokasi_id')
                ->references('kode_lokasi')
                ->on('lokasis')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raks');
    }
};
