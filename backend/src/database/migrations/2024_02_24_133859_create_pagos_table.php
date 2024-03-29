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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->string('forma_pago', 50)->nullable(false);
            $table->string('detalle', 200)->nullable(false);
            $table->decimal('monto', 10, 2)->nullable(false);
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->unsignedBigInteger('cliente_id')->nullable(false);
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedTinyInteger('activo')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
