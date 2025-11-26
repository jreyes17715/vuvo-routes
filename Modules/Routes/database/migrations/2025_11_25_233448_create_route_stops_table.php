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
    Schema::create('route_stops', function (Blueprint $table) {
        $table->id();
        $table->foreignId('route_id')->constrained('routes')->cascadeOnDelete();
        
        // AQUÍ ESTÁ LA CLAVE: Vinculamos con la sucursal del otro módulo
        $table->foreignId('client_branch_id')->constrained('client_branches');
        
        $table->integer('sequence')->default(0); // Orden de visita (1, 2, 3...)
        
        // Estados de la visita
        $table->string('status')->default('pending'); // pending, completed, skipped
        $table->text('notes')->nullable();
        
        // Opcional: Guardar snapshot de la dirección por si el cliente se muda después
        $table->decimal('arrival_latitude', 10, 8)->nullable();
        $table->decimal('arrival_longitude', 11, 8)->nullable();
        $table->timestamp('arrived_at')->nullable();
        
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('route_stops');
    }
};
