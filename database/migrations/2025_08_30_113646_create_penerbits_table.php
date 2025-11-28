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
        Schema::create('penerbits', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_penerbit', 100)->nullable();
            $table->unsignedInteger('tempat_id')->nullable();
            $table->timestamps();

            $table->foreign('tempat_id')
                ->references('id')
                ->on('tempat_penerbits')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penerbits');
    }
};
