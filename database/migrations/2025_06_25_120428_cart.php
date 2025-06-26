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
        Schema::create('cart', function (Blueprint $table) {
            $table->id();
            $table->string('id_cart')->unique();
            $table->string('product_id');
            $table->integer('quantity');
            $table->string('variation')->nullable(); // Add variation field
            $table->decimal('total_price', 15, 2);
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('product_id')->references('product_id')->on('product')->onDelete('cascade');
            
            // Index for better performance
            $table->index(['product_id', 'variation']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart');
    }
};