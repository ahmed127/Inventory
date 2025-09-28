<?php

namespace App\Services;

use App\Models\StockLog;

class StockLogServices
{
    private StockLog $stockLog;
    protected $product_id;
    protected $quantity;

    /**
     * Create a new class instance.
     */
    public function __construct(
        int $warehouse_id,
        int $user_id,
        int $product_id,
        int $quantity
    ) {
        $this->stockLog = StockLog::create([
            'warehouse_id' => $warehouse_id,
            'user_id'      => $user_id,
            'product_id'   => $product_id,
            'quantity'     => $quantity,
            'from_warehouse_id' => null
        ]);
        $this->product_id = $product_id;
        $this->quantity = $quantity;
    }

    public function transfer(int $from_warehouse_id): void
    {
        $this->stockLog->from_warehouse_id = $from_warehouse_id;
        $this->stockLog->type = StockLog::TYPE_TRANSFER;
        $this->stockLog->save();
    }

    public function refill(): void
    {
        $this->stockLog->type = StockLog::TYPE_REFILL;
        $this->stockLog->save();
    }

    public function order(): void
    {
        $this->stockLog->type = StockLog::TYPE_ORDER;
        $this->stockLog->save();
    }

    public function return(): void
    {
        $this->stockLog->type = StockLog::TYPE_RETURN;
        $this->stockLog->save();
    }
}
