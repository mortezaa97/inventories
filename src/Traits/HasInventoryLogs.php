<?php

namespace Mortezaa97\Inventories\Traits;

use Mortezaa97\Inventories\Models\Inventory;
use Mortezaa97\Inventories\Models\InventoryLog;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasInventoryLogs
{
    /**
     * Get all inventory logs for this model.
     */
    public function inventoryLogs(): MorphMany
    {
        return $this->morphMany(InventoryLog::class, 'model');
    }

    /**
     * Add an inventory log entry.
     *
     * @param int $inventoryId The inventory ID
     * @param int $count The count to add or subtract
     * @param bool $type The type (0 = increase, 1 = decrease)
     * @param int|null $userId The user ID (defaults to authenticated user)
     * @return InventoryLog
     */
    public function addInventoryLog(int $inventoryId, int $count, bool $type, ?int $userId = null): InventoryLog
    {
        $userId = $userId ?? auth()->id();

        return $this->inventoryLogs()->create([
            'inventory_id' => $inventoryId,
            'count' => $count,
            'type' => $type,
            'created_by' => $userId,
            'updated_by' => $userId,
        ]);
    }

    /**
     * Increase inventory and log the change.
     *
     * @param int $inventoryId The inventory ID
     * @param int $count The count to increase
     * @param int|null $userId The user ID (defaults to authenticated user)
     * @return InventoryLog
     */
    public function increaseInventory(int $inventoryId, int $count, ?int $userId = null): InventoryLog
    {
        // Update inventory count
        $inventory = Inventory::findOrFail($inventoryId);
        $inventory->count += $count;
        $inventory->updated_by = $userId ?? auth()->id();
        $inventory->save();

        // Log the change (type 0 = increase)
        return $this->addInventoryLog($inventoryId, $count, false, $userId);
    }

    /**
     * Decrease inventory and log the change.
     *
     * @param int $inventoryId The inventory ID
     * @param int $count The count to decrease
     * @param int|null $userId The user ID (defaults to authenticated user)
     * @return InventoryLog
     */
    public function decreaseInventory(int $inventoryId, int $count, ?int $userId = null): InventoryLog
    {
        // Update inventory count
        $inventory = Inventory::findOrFail($inventoryId);
        $inventory->count -= $count;
        $inventory->updated_by = $userId ?? auth()->id();
        $inventory->save();

        // Log the change (type 1 = decrease)
        return $this->addInventoryLog($inventoryId, $count, true, $userId);
    }

    /**
     * Get inventory logs for a specific inventory.
     *
     * @param int $inventoryId The inventory ID
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function inventoryLogsFor(int $inventoryId): MorphMany
    {
        return $this->inventoryLogs()->where('inventory_id', $inventoryId);
    }
}

