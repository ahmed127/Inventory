<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockLog extends Model
{
    protected $table = 'stock_logs';
    protected $guarded = [];

    const TYPE_REFILL   = 1; // Refill or Add to Stock
    const TYPE_TRANSFER = 2; // Transfer between warehouses
    const TYPE_ORDER    = 3; // Order from Supplier
    const TYPE_RETURN   = 4; // Return to Supplier

    public function types(): array
    {
        return [
            self::TYPE_REFILL   => 'Refill',
            self::TYPE_TRANSFER => 'Transfer',
            self::TYPE_ORDER    => 'Order',
            self::TYPE_RETURN   => 'Return',
        ];
    }

    public function getTypeTextAttribute()
    {
        return $this->types()[$this->type];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function from_warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'from_warehouse_id');
    }

    public function to_warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }
}
