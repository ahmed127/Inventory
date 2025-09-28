<?php

namespace App\UseCases;

use App\Services\StockServices;
use App\Services\StockLogServices;
use Illuminate\Support\Facades\DB;

class CreateOrderUseCase
{
    protected int $warehouse_id;
    protected int $user_id;
    protected int $product_id;
    protected int $quantity;

    /**
     * Create a new class instance.
     */
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
            if ($stockServices->getStock()->isAvailableQuantity($this->quantity)) {
                $stockServices->getStock()->updateQuantity($this->quantity, true);
                $stockLogServices = new StockLogServices($this->warehouse_id, $this->user_id, $this->product_id, $this->quantity);
                $stockLogServices->order();
                return [
                    'status' => true,
                    'message' => 'Order created successfully.'
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
