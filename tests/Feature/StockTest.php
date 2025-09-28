<?php

use App\Models\Product;
use App\Models\Stock;
use App\Models\User;
use App\Models\Warehouse;
use App\UseCases\CreateOrderUseCase;
use App\UseCases\RefillStockUseCase;
use App\UseCases\TransferStockUseCase;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('that stock is ordered', function () {
    $user = User::factory()->create();
    $warehouse = Warehouse::factory()->create();
    $product = Product::factory()->create();
    Stock::factory()->create([
        'warehouse_id' => $warehouse->id,
        'product_id' => $product->id,
        'quantity' => 100
    ]);
    $response = new CreateOrderUseCase($warehouse->id, $user->id, $product->id, 10)->execute();
    expect($response['status'])->toBeTrue();
});

test('that stock is refilled', function () {
    $user = User::factory()->create();

    $warehouse = Warehouse::factory()->create();
    $product = Product::factory()->create();
    $response = new RefillStockUseCase($warehouse->id, $user->id, $product->id, 10)->execute();
    expect($response['status'])->toBeTrue();
});

test('that stock is transferred', function () {
    $from_warehouse = Warehouse::factory()->create();
    $to_warehouse = Warehouse::factory()->create();
    $product = Product::factory()->create();
    $user = User::factory()->create();
    Stock::factory()->create([
        'warehouse_id' => $from_warehouse->id,
        'product_id' => $product->id,
        'quantity' => 10
    ]);
    $response = new TransferStockUseCase($from_warehouse->id, $to_warehouse->id, $user->id, $product->id,  1)->execute();
    expect($response['status'])->toBeTrue();
});
test('that stock is not enough', function () {
    $from_warehouse = Warehouse::factory()->create();
    $to_warehouse = Warehouse::factory()->create();
    $product = Product::factory()->create();
    $user = User::factory()->create();
    Stock::factory()->create([
        'warehouse_id' => $from_warehouse->id,
        'product_id' => $product->id,
        'quantity' => 10
    ]);
    $response = new TransferStockUseCase($from_warehouse->id, $to_warehouse->id, $user->id, $product->id, 11)->execute();
    expect($response['status'])->toBeFalse();
});
