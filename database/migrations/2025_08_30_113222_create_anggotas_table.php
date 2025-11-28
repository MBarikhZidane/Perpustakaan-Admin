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
        Schema::create('anggotas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('member_id', 50)->unique();
            $table->string('nama', 100);
            $table->unsignedInteger('tipe_anggota_id');
            $table->text('kelas')->nullable();
            $table->text('alamat')->nullable();
            $table->string('telepon', 20)->nullable();
            $table->boolean('is_pending')->default(false);
            $table->boolean('status_marker')->default(false);
            $table->timestamps();

            $table->foreign('tipe_anggota_id')
                ->references('id')
                ->on('tipe_anggotas')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggotas');
    }
};
