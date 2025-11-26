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
    // 1. Tabla de Clientes (La Cuenta Madre)
    Schema::create('clients', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Ej: "Coca Cola Embotelladora"
        $table->string('tax_id')->nullable(); // NIT o RUC
        $table->string('main_phone')->nullable();
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });

    // 2. Tabla de Sucursales / Puntos de Entrega (Donde va el camión)
    Schema::create('client_branches', function (Blueprint $table) {
        $table->id();
        $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
        
        $table->string('name'); // Ej: "Sucursal La Esperanza"
        $table->string('code')->nullable(); // Código interno de la tienda si tienen
        $table->string('address'); // Dirección legible
        
        // GEOESPACIAL: ¡Vital para tus rutas!
        // Usamos geography para cálculos precisos de distancia
        // Si no tienes configurado el tipo 'geography' en Laravel aún, usa decimales temporalmente, 
        // pero como dijiste PostGIS, lo ideal es esto:
        //$table->geography('location', subtype: 'point', srid: 4326)->nullable();
        // NOTA: Para evitar errores si no tienes el driver doctrine/dbal configurado para geo,
        // usaremos decimales por ahora y luego te enseño a castearlo, o si ya sabes usar PostGIS directo:
        $table->decimal('latitude', 10, 8)->nullable();
        $table->decimal('longitude', 11, 8)->nullable();

        $table->string('contact_name')->nullable(); // Encargado de tienda
        $table->string('contact_phone')->nullable();
        
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
