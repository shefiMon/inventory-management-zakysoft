<?php

namespace App\Listeners;

use App\Events\StockMovementCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;

use function Illuminate\Log\log;

class ClearStockMovementCache
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(StockMovementCreated $event): void
    {
         $productId = $event->stockMovement->product_id;
        $warehouseId = $event->stockMovement->warehouse_id;
        log("Clearing cache for product: {$productId}, warehouse: {$warehouseId}");
        Cache::forget("inventory_report_all_all");
        Cache::forget("inventory_report_{$productId}_all");
        Cache::forget("inventory_report_all_{$warehouseId}");
        Cache::forget("inventory_report_{$productId}_{$warehouseId}");
    }
}
