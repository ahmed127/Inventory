<?php

use App\Models\Stock;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Event;
use App\Events\LowStock;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('dispatches LowStock', function () {

    Event::fake();
    // 2. Trigger the event
    $warehouse = Warehouse::factory()->create();
    $product = Product::factory()->create();
    $stock = Stock::factory()->create([
        'warehouse_id' => $warehouse->id,
        'product_id' => $product->id,
        'quantity' => 100
    ]);
    event(new LowStock($stock));
    Event::assertDispatched(LowStock::class);
});
