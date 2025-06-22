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
       Schema::create('seller', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->char('seller_id', 5)->primary();
            $table->string('username_seller', 50);
            $table->string('seller_phone_number', 23);
            $table->string('seller_address', 50);
            $table->string('email', 50);
            $table->string('full_name', 50);
            $table->string('shop_name', 50);
            $table->char('business_type', 20);
            $table->string('shop_description', 50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller');
    }
};
