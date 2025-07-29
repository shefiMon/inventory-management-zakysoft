<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WareHouse;
use Faker\Factory as Faker;

class WareHouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            WareHouse::create([
                'name' => $faker->company . ' Warehouse',
                'location' => $faker->city,
            ]);
        }
    }
}
