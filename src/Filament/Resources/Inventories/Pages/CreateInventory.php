<?php

declare(strict_types=1);

namespace Mortezaa97\Inventories\Filament\Resources\Inventories\Pages;

use Mortezaa97\Inventories\Filament\Resources\Inventories\InventoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInventory extends CreateRecord
{
    protected static string $resource = InventoryResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();

        return $data;
    }
}

