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
        Schema::create('stock_opnames', function (Blueprint $table) {
            $table->increments('id');
            $table->string('stock_take_name', 100);
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();
            $table->string('init_user', 50)->nullable();
            $table->integer('total_item_stocktaked')->nullable();
            $table->integer('total_item_lost')->nullable();
            $table->integer('total_item_exists')->default(0);
            $table->integer('total_item_loan')->nullable();
            $table->text('stock_take_users')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_opnames');
    }
};
