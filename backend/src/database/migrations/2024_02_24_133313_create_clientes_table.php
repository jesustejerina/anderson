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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombres',50)->nullable(false);
            $table->string('apellidos',50)->nullable(false);
            $table->string('email',50)->nullable(false);
            $table->decimal('total_pagos',10,2)->default(0.00);
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->unsignedTinyInteger('activo')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
