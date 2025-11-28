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
        Schema::create('tujuan_bebas_perpustakaans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode_tujuan', 20)->unique();
            $table->string('nama_tujuan', 100);
            $table->string('idz', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tujuan_bebas_perpustakaans');
    }
};
