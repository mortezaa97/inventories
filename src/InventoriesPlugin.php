<?php

namespace Mortezaa97\Inventories;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Mortezaa97\Inventories\Filament\Resources\Inventories\InventoryResource;
use Mortezaa97\Inventories\Filament\Resources\InventoryLogs\InventoryLogResource;

class InventoriesPlugin implements Plugin
{
    public function getId(): string
    {
        return 'inventories';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                InventoryResource::class,
                InventoryLogResource::class,
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
