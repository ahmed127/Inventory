<?php

namespace App\Http\Controllers\Api;

use App\Models\Stock;
use App\Models\StockLog;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\UseCases\CreateOrderUseCase;
use App\UseCases\RefillStockUseCase;
use App\Http\Resources\StockResource;
use App\UseCases\TransferStockUseCase;
use App\Http\Controllers\ApiController;
use App\Http\Resources\StockLogResource;
use App\Http\Resources\WarehouseResource;

class MainController extends ApiController
{

    public function stock_log(Request $request)
    {
        $stockLogs = StockLog::latest()->paginate(10);

        return $this->successResponse(
            StockLogResource::collection($stockLogs)
        );
    }
    public function warehouses(Request $request)
    {
        $warehouses = Warehouse::paginate(10);

        return $this->successResponse(
            WarehouseResource::collection($warehouses)
        );
    }
    public function stock(Warehouse $warehouse, Request $request)
    {
        $stocks = Stock::where('warehouse_id', $warehouse->id)->paginate(10);

        return $this->successResponse(
            StockResource::collection($stocks)
        );
    }
    public function inventory(Warehouse $warehouse, Request $request)
    {
        return Warehouse::all();
    }

    public function transfer(Request $request)
    {
        $request->validate([
            'from_warehouse_id' => 'required|exists:warehouses,id',
            'to_warehouse_id' => 'required|exists:warehouses,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric',
        ]);

        $response = new TransferStockUseCase(
            $request->from_warehouse_id,
            $request->to_warehouse_id,
            auth('sanctum')->user()->id,
            $request->product_id,
            $request->quantity
        )->execute();

        if (!$response['status']) {
            return $this->errorResponse($response['message']);
        }
        return $this->successResponse($response['message']);
    }

    public function refill(Request $request)
    {
        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric',
        ]);

        $response = new RefillStockUseCase(
            $request->warehouse_id,
            auth('sanctum')->user()->id,
            $request->product_id,
            $request->quantity
        )->execute();

        if (!$response['status']) {
            return $this->errorResponse($response['message']);
        }
        return $this->successResponse($response['message']);
    }

    public function order(Request $request)
    {
        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric',
        ]);

        $response = new CreateOrderUseCase(
            $request->warehouse_id,
            auth('sanctum')->user()->id,
            $request->product_id,
            $request->quantity
        )->execute();

        if (!$response['status']) {
            return $this->errorResponse($response['message']);
        }
        return $this->successResponse($response['message']);
    }
}
