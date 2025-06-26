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
        Schema::create('detail_orders', function (Blueprint $table) {
            $table->string('detail_id', 6)->primary(); // e.g., DTL00001
            $table->string('order_id', 5); // Foreign key to orders table
            $table->string('product_id', 5); // Foreign key to product table
            $table->integer('quantity'); // Quantity of this product in the order
            $table->decimal('price_at_order', 10, 2); // Store price at the time of order
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
            $table->foreign('product_id')->references('product_id')->on('product')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_orders');
    }
};