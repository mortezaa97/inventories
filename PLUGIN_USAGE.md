# Inventories Plugin Usage

## Installation

The Inventories package is a Filament plugin that manages inventory and inventory logs with full tracking capabilities.

## Quick Start

### 1. Register the Plugin in your Filament Panel

In your `app/Providers/Filament/AdminPanelServiceProvider.php`, register the plugin:

```php
<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Mortezaa97\Inventories\InventoriesPlugin;

class AdminPanelServiceProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->plugins([
                InventoriesPlugin::make(),
            ])
            // ... other configurations
    }
}
```

### 2. Run Migrations

The migrations are automatically loaded by the service provider:

```bash
php artisan migrate
```

### 3. Clear Caches

```bash
php artisan config:clear
php artisan route:clear
php artisan cache:clear
```

## Features

### Models
- **Inventory**: Main inventory model with count tracking
- **InventoryLog**: Polymorphic inventory change logs (increase/decrease)

### Trait: HasInventoryLogs

Add inventory tracking to any model:

```php
use Mortezaa97\Inventories\Traits\HasInventoryLogs;

class Product extends Model
{
    use HasInventoryLogs;
    
    // Now your model has inventory tracking methods
}
```

### API Endpoints

The package automatically registers these routes:

```
GET    /api/inventories             - List all inventories
POST   /api/inventories             - Create a new inventory
GET    /api/inventories/{id}        - Show a specific inventory
PUT    /api/inventories/{id}        - Update an inventory
DELETE /api/inventories/{id}        - Delete an inventory

GET    /api/inventory-logs          - List all inventory logs
POST   /api/inventory-logs          - Create a new inventory log
GET    /api/inventory-logs/{id}     - Show a specific inventory log
PUT    /api/inventory-logs/{id}     - Update an inventory log
DELETE /api/inventory-logs/{id}     - Delete an inventory log
```

### Filament Resources

The plugin registers two resources:
- **InventoryResource**: Full CRUD interface for inventories
  - List Inventories page
  - Create Inventory page
  - Edit Inventory page
  - Inventory Logs Relation Manager
- **InventoryLogResource**: Full CRUD interface for inventory logs
  - List Inventory Logs page
  - Create Inventory Log page
  - Edit Inventory Log page

### Policies

The package includes policies for authorization:
- `InventoryPolicy`: Controls access to inventory operations
- `InventoryLogPolicy`: Controls access to inventory log operations

## Usage in Code

### Creating an Inventory

```php
use Mortezaa97\Inventories\Models\Inventory;

$inventory = Inventory::create([
    'name' => 'Main Warehouse',
    'count' => 100,
    'created_by' => auth()->id(),
    'updated_by' => auth()->id(),
]);
```

### Using the HasInventoryLogs Trait

```php
use Mortezaa97\Inventories\Traits\HasInventoryLogs;

class Product extends Model
{
    use HasInventoryLogs;
}

// Increase inventory
$product->increaseInventory(
    inventoryId: $inventoryId,
    count: 50,
    userId: auth()->id()
);

// Decrease inventory
$product->decreaseInventory(
    inventoryId: $inventoryId,
    count: 10,
    userId: auth()->id()
);

// Add a manual log entry
$product->addInventoryLog(
    inventoryId: $inventoryId,
    count: 5,
    type: false, // false = increase, true = decrease
    userId: auth()->id()
);

// Get all inventory logs for this product
$logs = $product->inventoryLogs;

// Get logs for a specific inventory
$logs = $product->inventoryLogsFor($inventoryId);
```

### Working with Inventory Logs

```php
use Mortezaa97\Inventories\Models\InventoryLog;

// Get all logs
$logs = InventoryLog::with(['inventory', 'model', 'createdBy'])->get();

// Get logs for a specific inventory
$logs = InventoryLog::where('inventory_id', $inventoryId)->get();

// Get increase logs only
$increases = InventoryLog::where('type', false)->get();

// Get decrease logs only
$decreases = InventoryLog::where('type', true)->get();
```

### Loading Relationships

```php
// Inventory with logs
$inventory = Inventory::with(['inventoryLogs', 'createdBy', 'updatedBy'])
    ->find($id);

// Inventory log with related models
$log = InventoryLog::with(['inventory', 'model', 'createdBy', 'updatedBy'])
    ->find($id);
```

## Inventory Log Types

```php
// Type: false (0) = Increase
// Type: true (1) = Decrease
```

## Customization

### Publishing Config

```bash
php artisan vendor:publish --tag="inventories-config"
```

### Publishing Migrations

```bash
php artisan vendor:publish --tag="inventories-migrations"
```

## Relation Manager

The package includes an `InventoryLogsRelationManager` that can be used in any Filament resource:

```php
use Mortezaa97\Inventories\Filament\Resources\Inventories\RelationManagers\InventoryLogsRelationManager;

public static function getRelations(): array
{
    return [
        InventoryLogsRelationManager::class,
    ];
}
```

## Example: Complete Product Inventory Flow

```php
use Mortezaa97\Inventories\Models\Inventory;
use Mortezaa97\Inventories\Traits\HasInventoryLogs;

class Product extends Model
{
    use HasInventoryLogs;
}

// Create an inventory
$mainWarehouse = Inventory::create([
    'name' => 'Main Warehouse',
    'count' => 0,
    'created_by' => auth()->id(),
]);

// Receive new products (increase inventory)
$product->increaseInventory($mainWarehouse->id, 100);
// Inventory count is now: 100

// Sell products (decrease inventory)
$product->decreaseInventory($mainWarehouse->id, 5);
// Inventory count is now: 95

// Check current inventory
$currentInventory = Inventory::find($mainWarehouse->id);
echo $currentInventory->count; // 95

// View all logs for this product
$allLogs = $product->inventoryLogs()
    ->with('inventory')
    ->orderBy('created_at', 'desc')
    ->get();
```

## Requirements

- PHP ^8.0
- Laravel ^10.0
- Filament ^3.0

