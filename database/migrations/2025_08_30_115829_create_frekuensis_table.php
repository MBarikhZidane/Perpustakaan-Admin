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
        Schema::create('frekuensis', function (Blueprint $table) {
            $table->increments('id');
            $table->string('frekuensi', 50)->nullable();
            $table->string('language_prefix', 10)->nullable();
            $table->integer('time_increment')->default(0);
            $table->string('time_unit', 20)->nullable();
            $table->timestamps();

            $table->foreign('language_prefix')
                ->references('kode_bahasa')
                ->on('bahasas')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('frekuensis');
    }
};
