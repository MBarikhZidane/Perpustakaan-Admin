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
        Schema::create('aturan_peminjamen', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('member_type_id');
            $table->unsignedInteger('coll_type_id');
            $table->unsignedInteger('gmd_id');
            $table->integer('loan_limit');
            $table->integer('loan_periode');
            $table->integer('reborrow_limit');
            $table->decimal('fine_each_day', 10, 2);
            $table->integer('grace_periode');
            $table->timestamps();

            $table->foreign('member_type_id')
                ->references('id')
                ->on('tipe_anggotas')
                ->onDelete('cascade');
            $table->foreign('coll_type_id')
                ->references('id')
                ->on('tipe_koleksis')
                ->onDelete('cascade');
            $table->foreign('gmd_id')
                ->references('id')
                ->on('gmds')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aturan_peminjamen');
    }
};
