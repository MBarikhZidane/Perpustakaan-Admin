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
        Schema::create('konfigurasi_penomorans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('idz', 20);
            $table->string('kode_group', 20)->unique();
            $table->string('nama_group', 100);
            $table->integer('konter')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konfigurasi_penomorans');
    }
};
