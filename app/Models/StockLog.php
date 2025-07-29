<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockLog extends Model
{
    protected $table = 'stock_logs';
    protected $fillable = [
        'stock_movement_id',
        'user_id',
        'action',
        'details',
    ];

    public function stockMovement()
    {
        return $this->belongsTo(StockMovement::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
