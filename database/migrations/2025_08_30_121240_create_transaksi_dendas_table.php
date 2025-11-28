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
        Schema::create('transaksi_dendas', function (Blueprint $table) {
            $table->increments('id');
            $table->date('tanggal');
            $table->string('member_id', 50);
            $table->decimal('debet', 10, 2)->default(0);
            $table->decimal('kredit', 10, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->string('status', 50)->nullable();
            $table->timestamps();

            $table->foreign('member_id')
                ->references('member_id')
                ->on('anggotas')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_dendas');
    }
};
