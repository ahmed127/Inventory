<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Stock;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Product::factory(10)->create();
        Warehouse::factory(3)->create();
        foreach (Warehouse::all() as $warehouse) {
            foreach (Product::all() as $product) {
                Stock::factory()->create([
                    'warehouse_id' => $warehouse->id,
                    'product_id' => $product->id
                ]);
            }
        }
    }
}
