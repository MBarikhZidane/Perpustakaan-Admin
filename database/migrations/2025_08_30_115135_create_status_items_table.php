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
        Schema::create('status_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode_status', 20)->unique();
            $table->string('nama_status', 50);
            $table->text('aturan')->nullable();
            $table->boolean('is_not_dipinjamkan')->default(false);
            $table->boolean('is_skip_stockopname')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_items');
    }
};
