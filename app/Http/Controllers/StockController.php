<?php

namespace App\Http\Controllers;

use App\Events\StockMovementCreated;
use App\Http\Requests\StockMovementRequest;
use App\Jobs\StockLogJob;
use App\Models\StockMovement;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StockController extends Controller
{


    public function create(StockMovementRequest $request)
    {
        $validated = $request->validated();

        try{

        DB::beginTransaction() ;

        $productId = $validated['product_id'];
        $warehouseId = $validated['warehouse_id'];


         $currentStock = StockMovement::where('product_id', $productId)
            ->where('warehouse_id', $warehouseId)
            ->selectRaw('SUM(CASE WHEN type = "in" THEN quantity ELSE -quantity END) as total')
            ->value('total') ?? 0;

            if($validated['type'] === 'out' && $currentStock < $validated['quantity']) {
                return response()->json([
                    'success' => false,
                    'error' => 'Insufficient stock for this operation.'
                ], Response::HTTP_BAD_REQUEST);
            }

            $stockMovement = StockMovement::create($validated);
            StockLogJob::dispatch($stockMovement)->afterCommit();
            event(new StockMovementCreated($stockMovement));
            DB::commit();
            return response()->json([
                'success' => true,
                'data' => $stockMovement
            ], Response::HTTP_CREATED);

        }catch(\Exception $e) {
            DB::rollBack();
            Log::debug('Failed to create stock movement: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'An error occurred while processing your request.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }



    }
}
