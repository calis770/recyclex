<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->char('product_id', 5)->primary();
            $table->string('product_name', 30);
            $table->decimal('price', 8, 2); // Changed to decimal for price
            $table->decimal('rating', 2, 1); // Changed to decimal for rating
            $table->string('image_product');
            $table->integer('sold');
            $table->text('description');
            $table->string('variasi')->nullable(); // Added nullable as variations might not always exist
            $table->string('category')->nullable(); // Added for consistency with fillable
            $table->string('umkm')->nullable(); // Added for consistency with fillable
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product');
    }
};