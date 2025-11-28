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
        Schema::create('items', function (Blueprint $table) {
            $table->string('kode_item', 50)->primary();
            $table->unsignedInteger('bibliografi_id');
            $table->string('call_number', 50)->nullable();
            $table->string('kode_inventori', 50)->nullable();
            $table->string('lokasi_id', 20)->nullable();
            $table->unsignedInteger('rak_id')->nullable();
            $table->unsignedInteger('tipe_koleksi_id')->nullable();
            $table->unsignedInteger('status_id')->nullable();
            $table->string('nmr_order', 50)->nullable();
            $table->date('tgl_order')->nullable();
            $table->date('tgl_penerimaan')->nullable();
            $table->unsignedInteger('supplier_id')->nullable();
            $table->string('source', 50)->nullable();
            $table->string('invoice', 50)->nullable();
            $table->date('tgl_invoice')->nullable();
            $table->decimal('harga', 10, 2)->default(0);
            $table->string('harga_currency', 10)->nullable();
            $table->boolean('is_fotocopy')->default(0);
            $table->boolean('status_marker')->default(0);
            $table->timestamps();

            $table->foreign('bibliografi_id')
                ->references('id')
                ->on('bibliografis')
                ->onDelete('cascade');
            $table->foreign('lokasi_id')
                ->references('kode_lokasi')
                ->on('lokasis')
                ->onDelete('set null');
            $table->foreign('rak_id')
                ->references('id')
                ->on('raks')
                ->onDelete('set null');
            $table->foreign('tipe_koleksi_id')
                ->references('id')
                ->on('tipe_koleksis')
                ->onDelete('set null');
            $table->foreign('status_id')
                ->references('id')
                ->on('status_items')
                ->onDelete('set null');
            $table->foreign('supplier_id')
                ->references('id')
                ->on('suppliers')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
