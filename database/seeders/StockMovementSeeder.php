<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\StockMovement;

class StockMovementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::pluck('id')->toArray();
        $warehouses = Warehouse::pluck('id')->toArray();

        $movements = [];
        $stockLevels = [];
        for ($i = 0; $i < 10000; $i++) {
            $date = now()->subDays(rand(0, 30));

                $productId = $products[array_rand($products)];
                $warehouseId = $warehouses[array_rand($warehouses)];
                $key = "$productId:$warehouseId";

            if (!isset($stockLevels[$key])) {
                $stockLevels[$key] = 0;
            }

            // Randomly choose type: "in" or "out" (80% in, 20% out for stability)
            $type = rand(1, 100) <= 20 && $stockLevels[$key] > 0 ? 'out' : 'in';

            // Quantity logic
            if ($type === 'in') {
                $quantity = rand(1, 20);
                $stockLevels[$key] += $quantity;
            } else {
                $quantity = rand(1, min(10, $stockLevels[$key]));
                $stockLevels[$key] -= $quantity;
            }

            $movements[] = [
                'product_id' =>   $productId,
                'warehouse_id' => $warehouseId,
                'quantity' => $quantity,
                'type' => $type,
                'movement_date' => $date->format('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        foreach (array_chunk($movements, 1000) as $chunk) {
            StockMovement::insert($chunk);
        }

    }
}
