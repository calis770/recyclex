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
        Schema::create('customer', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->char('customer_id', 5)->primary();
            $table->string('full_name', 50);
            $table->string('email', 50);
            $table->string('phone_number', 13);
            $table->string('password');
            $table->string('customer_address', 30);
            $table->string('username_customer', 30);
         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer');
    }
};
