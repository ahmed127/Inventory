<?php

namespace App\Services;

use App\Models\Stock;
use App\Events\LowStock;
use phpDocumentor\Reflection\Types\Boolean;

class StockServices
{
    public Stock $stock;
    public $warehouse_id;
    public $product_id;

    /**
     * Create a new class instance.
     */
    public function __construct(
        int $warehouse_id,
        int $product_id
    ) {
        $this->warehouse_id = $warehouse_id;
        $this->product_id = $product_id;
    }

    public function getStock(): self
    {
        $this->stock = Stock::where([
            'warehouse_id' => $this->warehouse_id,
            'product_id' => $this->product_id,
        ])->first();

        return $this;
    }

    public function firstOrNew(): self
    {
        $this->stock = Stock::updateOrCreate([
            'warehouse_id' => $this->warehouse_id,
            'product_id' => $this->product_id,
        ]);

        return $this;
    }

    public function updateQuantity($quantity, $is_deduct = false): self
    {
        if ($is_deduct) {
            $this->stock->quantity -= $quantity;
        } else {
            $this->stock->quantity += $quantity;
        }
        $this->stock->save();

        if ($this->stock->quantity <= $this->stock->min_quantity) {
            // Run Event LowStock
            event(new LowStock($this->stock));
        }
        return $this;
    }

    public function isAvailableQuantity($quantity): bool
    {
        $res = $this->stock->quantity > $quantity;
        if (!$res) {
            event(new LowStock($this->stock));
        }
        return $res;
    }

    // Update Min Quantity
    public function updateMinQuantity($min_quantity): self
    {
        $this->stock->min_quantity = $min_quantity;
        $this->stock->save();

        return $this;
    }

    public function first(): Stock
    {
        return $this->stock;
    }
}
