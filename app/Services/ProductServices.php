<?php

namespace App\Services;

use App\Models\Product;

class ProductServices
{

    public function updateOrCreate($sku, $name): Product
    {
        return Product::updateOrCreate([
            'sku' => $sku
        ], [
            'name' => $name
        ]);
    }

    public function single(int $product_id): Product
    {
        return Product::find($product_id);
    }

    public function list(string $search, int $perPage = 10): array
    {
        return Product::when($search, function ($query) use ($search) {
            $query->whereLike('name', '%' . $search . '%');
        })->paginate($perPage);
    }
}
