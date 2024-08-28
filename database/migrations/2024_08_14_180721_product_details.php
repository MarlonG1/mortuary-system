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
       Schema::create('product_details',  function (Blueprint $table) {
           $table->id();
           $table->foreignId('product_id');
           $table->double('price');
           $table->integer('initial_stock')->nullable();
           $table->integer('current_stock')->nullable();
           $table->string('image')->nullable();
       });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_details');
    }
};
