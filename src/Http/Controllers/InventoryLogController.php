<?php

namespace Mortezaa97\Inventories\Http\Controllers;

use Mortezaa97\Inventories\Models\InventoryLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Mortezaa97\Inventories\Http\Resources\InventoryLogResource;

class InventoryLogController
{
    public function index()
    {
        Gate::authorize('viewAny', InventoryLog::class);
        return InventoryLogResource::collection(InventoryLog::all());
    }

    public function store(Request $request)
    {
        Gate::authorize('create', InventoryLog::class);
        try {
            DB::beginTransaction();
            // TODO: Implement store logic
            $inventoryLog = InventoryLog::create($request->validated());
            DB::commit();
            return new InventoryLogResource($inventoryLog);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json($exception->getMessage(),419);
        }
    }

    public function show(InventoryLog $inventoryLog)
    {
        Gate::authorize('view', $inventoryLog);
        return new InventoryLogResource($inventoryLog);
    }

    public function update(Request $request, InventoryLog $inventoryLog)
    {
        Gate::authorize('update', $inventoryLog);
        try {
            DB::beginTransaction();
            // TODO: Implement update logic
            $inventoryLog->update($request->validated());
            DB::commit();
            return new InventoryLogResource($inventoryLog);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json($exception->getMessage(),419);
        }
    }

    public function destroy(InventoryLog $inventoryLog)
    {
        Gate::authorize('delete', $inventoryLog);
        try {
            DB::beginTransaction();
            $inventoryLog->delete();
            DB::commit();
            return response()->json("با موفقیت حذف شد");
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json($exception->getMessage(),419);
        }
    }
}

