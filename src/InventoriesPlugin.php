<?php

declare(strict_types=1);

namespace Mortezaa97\Brands;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Mortezaa97\Brands\Filament\Resources\Brands\BrandResource;

class InventoriesPlugin implements Plugin
{
    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'inventories';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                // 'BrandResource' => BrandResource::class,
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
