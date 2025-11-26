<?php

namespace Modules\Clients\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClientBranch extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'name', 'code', 'address', 
        'latitude', 'longitude', 'contact_name', 'contact_phone', 'is_active'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    
    // Accessor para mostrar el nombre completo en los selectores
    // Ej: "Coca Cola - Sucursal La Esperanza"
    public function getFullNameAttribute()
    {
        return "{$this->client->name} - {$this->name}";
    }
}