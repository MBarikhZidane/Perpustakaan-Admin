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
        Schema::create('tipe_koleksis', function (Blueprint $table) {
            $table->increments('id');
            $table->string('idz', 20);
            $table->string('nama_tipe_koleksi', 100);
            $table->string('urutan', 10)->default('0');
            $table->string('kd_group_konter', 20);
            $table->string('prefix', 20)->nullable();
            $table->string('nama_group_konter', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipe_koleksis');
    }
};
