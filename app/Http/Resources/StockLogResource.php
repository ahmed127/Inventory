<?php

namespace App\Http\Resources;

use App\Http\Resources\ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;


class StockLogResource extends JsonResource
{

    public function toArray($request): array
    {

        return [
            "from_warehouse" => new WarehouseResource($this->from_warehouse),
            "to_warehouse"   => new WarehouseResource($this->to_warehouse),
            "product"        => new ProductResource($this->product),
            "quantity"       => $this->quantity,
            "user_name"      => $this->user->name,
            "type"           => $this->type_text,
            "created_at"     => $this->created_at
        ];
    }
}
