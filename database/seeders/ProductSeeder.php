<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $products = [];
        for ($i = 0; $i < 1000; $i++) {
            $product_name = $faker->word;
            $sku = 'SKU-' . strtoupper($product_name) . '-' . (string) Str::uuid();
            $products[] = [
                'name' => $product_name,
                'description' => $faker->sentence,
                'sku' => $sku,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Product::insert($products);
    }
}


