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
        Schema::create('transacciones_billeteras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('billetera_id')
                  ->constrained('billeteras')
                  ->onDelete('restrict');
            $table->string('token', 6);
            $table->string('id_sesion')->unique();
            $table->decimal('monto', 10, 2);
            $table->enum('estado', ['completada', 'pendiente', 'fallida'])
                  ->default('pendiente');
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->timestamp('fecha_actualizacion')->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transacciones_billeteras');
    }
};
