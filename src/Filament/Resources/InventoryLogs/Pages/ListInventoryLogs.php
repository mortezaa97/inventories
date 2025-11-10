<?php

declare(strict_types=1);

namespace Mortezaa97\Inventories\Filament\Resources\InventoryLogs\Pages;

use Mortezaa97\Inventories\Filament\Resources\InventoryLogs\InventoryLogResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInventoryLogs extends ListRecords
{
    protected static string $resource = InventoryLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

