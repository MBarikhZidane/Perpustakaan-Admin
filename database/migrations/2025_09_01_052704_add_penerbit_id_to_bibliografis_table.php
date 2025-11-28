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
        Schema::table('bibliografis', function (Blueprint $table) {
            $table->unsignedInteger('penerbit_id')->nullable()->after('tipe_koleksi_id');
            $table->foreign('penerbit_id')->references('id')->on('penerbits')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bibliografis', function (Blueprint $table) {
            $table->dropForeign(['penerbit_id']);
            $table->dropColumn('penerbit_id');
        });
    }
};
