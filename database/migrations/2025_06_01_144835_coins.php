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
         Schema::create('coins', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->char('coins_id', 5)->primary();
            $table->integer('coins_total');
            $table->integer('coins_earned');
         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coins');
    }
};
