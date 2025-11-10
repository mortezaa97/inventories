<?php

declare(strict_types=1);

namespace Mortezaa97\Inventories\Filament\Resources\Inventories;

use Mortezaa97\Inventories\Filament\Resources\Inventories\Pages\CreateInventory;
use Mortezaa97\Inventories\Filament\Resources\Inventories\Pages\EditInventory;
use Mortezaa97\Inventories\Filament\Resources\Inventories\Pages\ListInventories;
use Mortezaa97\Inventories\Filament\Resources\Inventories\Schemas\InventoryForm;
use Mortezaa97\Inventories\Filament\Resources\Inventories\Tables\InventoriesTable;
use Mortezaa97\Inventories\Filament\Resources\Inventories\RelationManagers\InventoryLogsRelationManager;
use Mortezaa97\Inventories\Models\Inventory;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class InventoryResource extends Resource
{
    protected static ?string $model = Inventory::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationLabel = 'انبارها';

    protected static ?string $modelLabel = 'انبار';

    protected static ?string $pluralModelLabel = 'انبارها';

    protected static string|null|UnitEnum $navigationGroup = 'انبار';

    public static function form(Schema $schema): Schema
    {
        return InventoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InventoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            InventoryLogsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInventories::route('/'),
            'create' => CreateInventory::route('/create'),
            'edit' => EditInventory::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}

