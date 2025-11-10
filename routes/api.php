<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Mortezaa97\Inventories\Http\Controllers\InventoryController;
use Mortezaa97\Inventories\Http\Controllers\InventoryLogController;

Route::prefix('api')->middleware('api')->group(function () {
    Route::apiResource('inventories', InventoryController::class);
    Route::apiResource('inventory-logs', InventoryLogController::class);
});
