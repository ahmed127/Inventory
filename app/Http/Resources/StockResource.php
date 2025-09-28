<?php

namespace App\Http\Resources;

use App\Http\Resources\ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;


class StockResource extends JsonResource
{

    public function toArray($request): array
    {

        return [
            // "warehouse" => new WarehouseResource($this->warehouse),
            "product"   => new ProductResource($this->product),
            "quantity"  => $this->quantity,
        ];
    }
}
