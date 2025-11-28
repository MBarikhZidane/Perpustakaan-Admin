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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_supplier', 150);
            $table->text('alamat')->nullable();
            $table->string('kodepos', 10)->nullable();
            $table->string('telepon', 20)->nullable();
            $table->string('kontak', 100)->nullable();
            $table->string('fax', 20)->nullable();
            $table->string('account', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
