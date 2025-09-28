<?php

namespace App\UseCases;

use App\Services\StockServices;
use App\Services\StockLogServices;

class TransferStockUseCase
{
    protected int $from_warehouse_id;
    protected int $to_warehouse_id;
    protected int $user_id;
    protected int $product_id;
    protected int $quantity;

    /**
     * Create a new class instance.
     */
    public function __construct(
        int $from_warehouse_id,
        int $to_warehouse_id,
        int $user_id,
        int $product_id,
        int $quantity
    ) {
        $this->from_warehouse_id = $from_warehouse_id;
        $this->to_warehouse_id = $to_warehouse_id;
        $this->user_id = $user_id;
        $this->product_id = $product_id;
        $this->quantity = $quantity;
    }

    public function execute(): array
    {
        try {
            $fromStockServices = new StockServices($this->from_warehouse_id, $this->product_id);
            if ($fromStockServices->getStock()->isAvailableQuantity($this->quantity)) {
                // Update From Stocks - Deduct
                $fromStockServices->getStock()->updateQuantity($this->quantity, true);

                // Update To Stocks - add
                $toStockServices = new StockServices($this->to_warehouse_id, $this->product_id);
                $toStockServices->firstOrNew()->updateQuantity($this->quantity);


                // Add Stock Log
                $stockLogServices = new StockLogServices($this->to_warehouse_id, $this->user_id, $this->product_id, $this->quantity);
                $stockLogServices->transfer($this->from_warehouse_id);
                return [
                    'status' => true,
                    'message' => 'Transfer successfully.'
                ];
            }
            return [
                'status' => false,
                'message' => 'Not enough stock.'
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
