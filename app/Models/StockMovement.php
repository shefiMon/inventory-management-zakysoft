<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    //
    protected $fillable = [
        'product_id',
        'warehouse_id',
        'quantity',
        'type',
        'movement_date',
        'created_at',
        'updated_at',
    ];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
