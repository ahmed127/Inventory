<?php

namespace App\UseCases;

use App\Services\StockServices;
use App\Services\StockLogServices;
use Illuminate\Support\Facades\DB;

class RefillStockUseCase
{
    private int $warehouse_id;
    private int $user_id;
    private int $product_id;
    private int $quantity;

    public function __construct(
        int $warehouse_id,
        int $user_id,
        int $product_id,
        int $quantity
    ) {
        $this->warehouse_id = $warehouse_id;
        $this->user_id = $user_id;
        $this->product_id = $product_id;
        $this->quantity = $quantity;
    }

    public function execute(): array
    {
        try {
            $stockServices = new StockServices($this->warehouse_id, $this->product_id);
            $stockServices->firstOrNew()->updateQuantity($this->quantity);

            // Add Stock Log
            $stockLogServices = new StockLogServices($this->warehouse_id, $this->user_id, $this->product_id, $this->quantity);
            $stockLogServices->refill();
            return [
                'status' => true,
                'message' => 'Refill stock successfully.'
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
