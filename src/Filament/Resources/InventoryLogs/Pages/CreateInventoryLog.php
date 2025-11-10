<?php

declare(strict_types=1);

namespace Mortezaa97\Inventories\Filament\Resources\InventoryLogs\Pages;

use Mortezaa97\Inventories\Filament\Resources\InventoryLogs\InventoryLogResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInventoryLog extends CreateRecord
{
    protected static string $resource = InventoryLogResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();

        return $data;
    }
}

