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
        Schema::create('transaksi_pemesanans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('member_id', 50);
            $table->unsignedInteger('bibliografi_id');
            $table->string('kode_item', 50)->nullable();
            $table->dateTime('reserve_date');
            $table->unsignedInteger('tipe_member_id');
            $table->boolean('is_mendapatkan')->default(false);
            $table->timestamps();

            $table->foreign('member_id')
                ->references('member_id')
                ->on('anggotas')
                ->onDelete('cascade');
            $table->foreign('bibliografi_id')
                ->references('id')
                ->on('bibliografis')
                ->onDelete('cascade');
            $table->foreign('kode_item')
                ->references('kode_item')
                ->on('items')
                ->onDelete('set null');
            $table->foreign('tipe_member_id')
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
        Schema::dropIfExists('transaksi_pemesanans');
    }
};
