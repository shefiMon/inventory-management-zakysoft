<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WareHouse extends Model
{
    //
    protected $table = 'warehouses';
    protected $fillable = [
        'name',
        'location',
    ];

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }
}
