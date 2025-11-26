<?php

namespace Modules\Inventory\app\Models;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'is_mobile',
        'plate_number',
        'is_active',
    ];

    protected $casts = [
        'is_mobile' => 'boolean',
        'is_active' => 'boolean',
    ];
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'warehouse_products')
                    ->withPivot('quantity', 'location_code') // Queremos ver la cantidad
                    ->withTimestamps();
    }
}