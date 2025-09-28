<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;


class ProductResource extends JsonResource
{

    public function toArray($request): array
    {

        return [
            "id"    => $this->id,
            "name"  => $this->name,
            "sku"   => $this->sku,
            'price' => $this->price,
        ];
    }
}
