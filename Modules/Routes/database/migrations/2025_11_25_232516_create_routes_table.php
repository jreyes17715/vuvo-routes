<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // xxxx_create_routes_table.php
        public function up(): void
        {
            Schema::create('routes', function (Blueprint $table) {
                $table->id();
                
                // Relación con el Chofer
                $table->foreignId('driver_id')->constrained('drivers');
                
                // Relación con el Camión (OJO: Apunta a tu tabla de warehouses del módulo Inventory)
                $table->foreignId('warehouse_id')->constrained('warehouses'); 
                
                // Datos operativos
                $table->date('scheduled_date'); // Fecha de la ruta
                $table->enum('status', ['draft', 'scheduled', 'active', 'completed', 'canceled'])->default('draft');
                
                // Métricas (se llenarán después)
                $table->timestamp('started_at')->nullable();
                $table->timestamp('completed_at')->nullable();
                
                $table->timestamps();
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};
