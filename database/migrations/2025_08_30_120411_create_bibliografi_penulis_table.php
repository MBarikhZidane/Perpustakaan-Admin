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
        Schema::create('bibliografi_penulis', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('bibliografi_id');
            $table->unsignedInteger('penulis_id');
            $table->char('tipe', 20)->nullable();
            $table->string('level', 10)->nullable();
            $table->string('kategori', 500)->nullable();
            $table->timestamps();

            $table->foreign('bibliografi_id')
                ->references('id')
                ->on('bibliografis')
                ->onDelete('cascade');
            $table->foreign('penulis_id')
                ->references('id')
                ->on('penulis')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bibliografi_penulis');
    }
};
