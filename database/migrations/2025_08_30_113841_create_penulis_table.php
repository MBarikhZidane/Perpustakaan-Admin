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
        Schema::create('penulis', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama', 100)->nullable();
            $table->integer('tahun')->nullable();
            $table->enum('tipe', ['Personal Name', 'Organization Body', 'Conference'])->nullable();
            $table->enum('kategori', ['Primary Author', 'Additional Author', 'Editor', 'Translator', 'Director', 'Producer', 'Composer', 'Illustrator', 'Creator', 'Contributor Name'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penulis');
    }
};
