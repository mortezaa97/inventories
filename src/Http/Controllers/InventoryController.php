<?php

namespace Mortezaa97\Inventories\Http\Controllers;

use Mortezaa97\Inventories\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Mortezaa97\Inventories\Http\Resources\InventoryResource;

class InventoryController
{
    public function index()
    {
        Gate::authorize('viewAny', Inventory::class);
        return InventoryResource::collection(Inventory::all());
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Inventory::class);
        try {
            DB::beginTransaction();
            // TODO: Implement store logic
            $inventory = Inventory::create($request->validated());
            DB::commit();
            return new InventoryResource($inventory);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json($exception->getMessage(),419);
        }
    }

    public function show(Inventory $inventory)
    {
        Gate::authorize('view', $inventory);
        return new InventoryResource($inventory);
    }

    public function update(Request $request, Inventory $inventory)
    {
        Gate::authorize('update', $inventory);
        try {
            DB::beginTransaction();
            // TODO: Implement update logic
            $inventory->update($request->validated());
            DB::commit();
            return new InventoryResource($inventory);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json($exception->getMessage(),419);
        }
    }

    public function destroy(Inventory $inventory)
    {
        Gate::authorize('delete', $inventory);
        try {
            DB::beginTransaction();
            $inventory->delete();
            DB::commit();
            return response()->json("با موفقیت حذف شد");
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json($exception->getMessage(),419);
        }
    }
}

