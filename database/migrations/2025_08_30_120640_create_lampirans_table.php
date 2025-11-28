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
        Schema::create('lampirans', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('bibliografi_id');
            $table->string('judul', 255);
            $table->string('nama_file', 255)->nullable();
            $table->text('deskripsi')->nullable();
            $table->enum('tipe_akses', ['Public', 'Private']);
            $table->timestamps();

            $table->foreign('bibliografi_id')
                ->references('id')
                ->on('bibliografis')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lampirans');
    }
};
