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
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Ej: "Bodega Central", "Camión 05"
            $table->string('address')->nullable();
            
            // El truco del arquitecto:
            $table->boolean('is_mobile')->default(false); // True = Camión
            
            // Si es camión, necesitamos saber la Placa
            $table->string('plate_number')->nullable(); 
            
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouses');
    }
};
