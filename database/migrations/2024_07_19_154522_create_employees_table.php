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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('office_id')
                ->constrained()
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->string('name');
            $table->string('lastname');
            $table->string('phone')->unique();
            $table->date('birth_date');
            $table->string('dui')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
