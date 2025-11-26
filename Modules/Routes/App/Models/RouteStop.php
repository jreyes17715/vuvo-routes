<?php

namespace Modules\Routes\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Clients\App\Models\ClientBranch; // Importante: Relación con el módulo Clients

class RouteStop extends Model
{
    use HasFactory;

    protected $fillable = [
        'route_id', 
        'client_branch_id', 
        'sequence', 
        'status', 
        'notes'
    ];

    // Relación inversa con la Ruta
    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    // Relación con la Sucursal (¿A dónde vamos?)
    public function branch()
    {
        return $this->belongsTo(ClientBranch::class, 'client_branch_id');
    }
}