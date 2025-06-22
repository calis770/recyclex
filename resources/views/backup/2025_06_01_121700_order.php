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
        Schema::create('orders', function (Blueprint $table) {
            $table->char('order_id', 5)->primary();
            $table->dateTime('order_date');
            $table->integer('total_price');
            $table->enum('status', ['UNPAID', 'PACKED', 'SENT', 'DONE', 'CANCELLED'])->default('UNPAID');
            $table->string('merchant_name');
            $table->string('product_name');
            $table->text('product_description')->nullable();
            $table->string('product_image')->nullable();
            $table->integer('quantity')->default(1);
            $table->integer('unit_price');
            $table->text('status_info')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};