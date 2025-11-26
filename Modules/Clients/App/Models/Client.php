<?php

namespace Modules\Clients\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'tax_id', 'main_phone', 'is_active'];

    // Un cliente tiene muchas sucursales
    public function branches()
    {
        return $this->hasMany(ClientBranch::class);
    }
}