<?php

namespace Modules\Inventory\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Inventory\Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    // ESTO ES LO QUE TE FALTABA: La lista blanca de campos permitidos
    protected $fillable = [
        'sku',
        'name',
        'description',
        'price',
        'stock_general',
        'is_active',
    ];

    // Opcional: Para castear tipos de datos automáticamente
    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'stock_general' => 'integer',
    ];
    public function warehouses(): BelongsToMany
    {
        return $this->belongsToMany(Warehouse::class, 'warehouse_products')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
    /* * Si usas factories en el futuro:
     */
    // protected static function newFactory(): ProductFactory
    // {
    //     return ProductFactory::new();
    // }
}