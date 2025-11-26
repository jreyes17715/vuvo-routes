<?php
namespace Modules\Routes\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Inventory\App\Models\Warehouse; // Importamos del otro módulo

class Route extends Model
{
    use HasFactory;

    protected $fillable = ['driver_id', 'warehouse_id', 'scheduled_date', 'status'];

    protected $casts = [
        'scheduled_date' => 'date',
    ];

    // Relación con el Chofer
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
    public function stops()
    {
        // Una ruta tiene muchas paradas
        return $this->hasMany(RouteStop::class)->orderBy('sequence');
    }

    // Relación con el Camión (Warehouse)
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}