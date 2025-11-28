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
        Schema::create('tipe_anggotas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_tipe', 50)->unique();
            $table->integer('limit_peminjaman');
            $table->integer('periode_peminjaman');
            $table->boolean('is_boleh_pesan')->default(false);
            $table->integer('limit_pemesanan');
            $table->integer('periode_member');
            $table->integer('limit_pinjam_ulang');
            $table->decimal('denda_per_hari', 10, 2);
            $table->integer('masa_tenggang');
            $table->boolean('is_siswa')->default(false);
            $table->boolean('is_guru')->default(false);
            $table->boolean('is_karyawan')->default(false);
            $table->boolean('is_external')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipe_anggotas');
    }
};
