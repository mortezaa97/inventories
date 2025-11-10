# Inventories Package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mortezaa97/inventories.svg?style=flat-square)](https://packagist.org/packages/mortezaa97/inventories)
[![Total Downloads](https://img.shields.io/packagist/dt/mortezaa97/inventories.svg?style=flat-square)](https://packagist.org/packages/mortezaa97/inventories)

A comprehensive Filament plugin for managing inventories and inventory logs with polymorphic tracking, full CRUD interface, and detailed history.

## Features

- 📦 **Inventory Management**: Track stock levels across multiple warehouses
- 📊 **Inventory Logs**: Complete history of all inventory changes
- 🔗 **Polymorphic Tracking**: Link inventory changes to any model (products, orders, etc.)
- 🎯 **HasInventoryLogs Trait**: Easy integration with existing models
- 🔐 **Authorization**: Built-in policies for secure access control
- 🌐 **API Ready**: RESTful API endpoints for all resources
- 📈 **Relation Manager**: Built-in Filament relation manager for inventory logs
- 🇮🇷 **Persian Support**: Full RTL and Persian language support

## Installation

### 1. Require the package via Composer

```bash
composer require mortezaa97/inventories
```

### 2. Register the Plugin

In your `app/Providers/Filament/AdminPanelServiceProvider.php`:

```php
use Mortezaa97\Inventories\InventoriesPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            InventoriesPlugin::make(),
        ]);
}
```

### 3. Run Migrations

```bash
php artisan migrate
```

### 4. Clear Caches

```bash
php artisan config:clear
php artisan cache:clear
```

## Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --tag="inventories-config"
```

Publish migrations:

```bash
php artisan vendor:publish --tag="inventories-migrations"
```

## Usage

See [PLUGIN_USAGE.md](PLUGIN_USAGE.md) for detailed usage instructions.

## Quick Example

```php
use Mortezaa97\Inventories\Models\Inventory;
use Mortezaa97\Inventories\Traits\HasInventoryLogs;

// Add trait to your model
class Product extends Model
{
    use HasInventoryLogs;
}

// Create inventory
$inventory = Inventory::create([
    'name' => 'Main Warehouse',
    'count' => 100,
    'created_by' => auth()->id(),
]);

// Increase inventory
$product->increaseInventory($inventory->id, 50);

// Decrease inventory
$product->decreaseInventory($inventory->id, 10);

// Get all logs
$logs = $product->inventoryLogs;
```

## Available Models

### Inventory
- Tracks stock levels
- Has many inventory logs
- Soft deletable

### InventoryLog
- Records all changes
- Polymorphic relationship to any model
- Tracks increase/decrease operations
- Soft deletable

## Available Trait

### HasInventoryLogs

Add inventory tracking to any model:

```php
use Mortezaa97\Inventories\Traits\HasInventoryLogs;

class YourModel extends Model
{
    use HasInventoryLogs;
    
    // Available methods:
    // - inventoryLogs()
    // - addInventoryLog()
    // - increaseInventory()
    // - decreaseInventory()
    // - inventoryLogsFor()
}
```

## API Routes

- `/api/inventories` - Inventory CRUD
- `/api/inventory-logs` - Inventory Log CRUD

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [mortezaa97](https://github.com/mortezaa97)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
