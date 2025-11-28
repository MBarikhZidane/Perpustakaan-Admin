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
        Schema::create('bibliografis', function (Blueprint $table) {
            $table->increments('id');
            $table->string('judul', 255);
            $table->string('edisi', 50)->nullable();
            $table->string('isbn_issn', 50)->nullable();
            $table->string('tahun_terbit', 10)->nullable();
            $table->string('collation', 100)->nullable();
            $table->string('judul_seri', 255)->nullable();
            $table->string('call_number', 50)->nullable();
            $table->unsignedInteger('gmd_id')->nullable();
            $table->string('bahasa_id', 10)->nullable();
            $table->unsignedInteger('tipe_koleksi_id')->nullable();
            $table->string('klasifikasi', 50)->nullable();
            $table->text('catatan')->nullable();
            $table->text('spec_detail_info')->nullable();
            $table->unsignedInteger('frekuensi_id')->nullable();
            $table->boolean('is_etalase_hide')->default(false);
            $table->boolean('is_promosi')->default(false);
            $table->string('gambar', 100)->nullable();
            $table->string('volume', 50)->nullable();
            $table->boolean('status_marker')->default(false);
            $table->timestamps();

            $table->foreign('gmd_id')
                ->references('id')
                ->on('gmds')
                ->onDelete('set null');
            $table->foreign('bahasa_id')
                ->references('kode_bahasa')
                ->on('bahasas')
                ->onDelete('set null');
            $table->foreign('tipe_koleksi_id')
                ->references('id')
                ->on('tipe_koleksis')
                ->onDelete('set null');
            $table->foreign('frekuensi_id')
                ->references('id')
                ->on('frekuensis')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bibliografis');
    }
};
