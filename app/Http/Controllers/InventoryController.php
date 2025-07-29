<?php

namespace App\Http\Controllers;

use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class InventoryController extends Controller
{
    public function report(Request $request){

        $productId = $request->query('product_id');
        $warehouseId = $request->query('warehouse_id');

        $cacheKey = "inventory_report_{$productId}_{$warehouseId}";

          $report = Cache::remember($cacheKey, 300, function () use ($productId, $warehouseId) {
           return  StockMovement::selectRaw('
                    product_id,
                    warehouse_id,
                    SUM(CASE WHEN type = "in" THEN quantity ELSE -quantity END) AS total_stock
                ')
                ->when($productId, fn($q) => $q->where('product_id', $productId))
                ->when($warehouseId, fn($q) => $q->where('warehouse_id', $warehouseId))
                ->groupBy('product_id', 'warehouse_id')
                ->with(['product:id,name,sku', 'warehouse:id,name,location'])->get();
          });



        return response()->json([
            'success' => true,
            'data' =>  $report
        ]);
    }
}
