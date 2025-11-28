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
        Schema::create('surat_bebas_perpustakaans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('idz', 20)->nullable();
            $table->date('tanggal');
            $table->string('member_id', 50);
            $table->unsignedInteger('tujuan_id')->nullable();
            $table->string('nomor_surat', 50);
            $table->string('id_penerima', 50)->nullable();
            $table->timestamps();

            $table->foreign('member_id')
                ->references('member_id')
                ->on('anggotas')
                ->onDelete('cascade');
            $table->foreign('tujuan_id')
                ->references('id')
                ->on('tujuan_bebas_perpustakaans')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_bebas_perpustakaans');
    }
};
