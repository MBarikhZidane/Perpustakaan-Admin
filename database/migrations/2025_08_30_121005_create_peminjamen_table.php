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
        Schema::create('peminjamen', function (Blueprint $table) {
            $table->increments('id');
            $table->string('member_id', 50);
            $table->string('kode_item', 50);
            $table->date('loan_date');
            $table->date('duedate');
            $table->date('return_date')->nullable();
            $table->boolean('is_return')->default(false);
            $table->timestamps();

            $table->foreign('member_id')
                ->references('member_id')
                ->on('anggotas')
                ->onDelete('cascade');
            $table->foreign('kode_item')
                ->references('kode_item')
                ->on('items')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamen');
    }
};
