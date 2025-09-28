<?php

namespace App\Services;

use App\Models\Warehouse;

class WarehouseServices
{
    public function updateOrCreate($code, $name, $address): Warehouse
    {
        return Warehouse::updateOrCreate([
            'code' => $code
        ], [
            'name'    => $name,
            'address' => $address,
        ]);
    }


    public function single(int $warehouse_id): Warehouse
    {
        return Warehouse::find($warehouse_id);
    }

    public function list(string $search, int $perPage = 10): array
    {
        return Warehouse::when($search, function ($query) use ($search) {
            $query->whereLike('name', '%' . $search . '%');
        })->paginate($perPage);
    }
}
