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
    Schema::create('warehouse_products', function (Blueprint $table) {
        $table->id();
        
        // Relaciones (Llaves foráneas)
        // Usamos foreignId para que Laravel entienda la relación automáticamente
        $table->foreignId('warehouse_id')->constrained()->onDelete('cascade');
        $table->foreignId('product_id')->constrained()->onDelete('cascade');
        
        // La cantidad exacta
        $table->integer('quantity')->default(0);
        
        // Opcional: Ubicación física dentro de la bodega (Pasillo A, Estante 2)
        // Muy útil para WMS, aunque sea ligero.
        $table->string('location_code')->nullable(); 

        $table->timestamps();
        
        // REGLA DE ORO: No puede haber duplicados de Bodega+Producto
        // (No puedes tener dos registros de Coca-Cola en la Bodega 1, solo uno con la suma)
        $table->unique(['warehouse_id', 'product_id']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouse_products');
    }
};
