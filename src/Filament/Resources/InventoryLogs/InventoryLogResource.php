<?php

declare(strict_types=1);

namespace Mortezaa97\Inventories\Filament\Resources\InventoryLogs;

use Mortezaa97\Inventories\Filament\Resources\InventoryLogs\Pages\CreateInventoryLog;
use Mortezaa97\Inventories\Filament\Resources\InventoryLogs\Pages\EditInventoryLog;
use Mortezaa97\Inventories\Filament\Resources\InventoryLogs\Pages\ListInventoryLogs;
use Mortezaa97\Inventories\Filament\Resources\InventoryLogs\Schemas\InventoryLogForm;
use Mortezaa97\Inventories\Filament\Resources\InventoryLogs\Tables\InventoryLogsTable;
use Mortezaa97\Inventories\Models\InventoryLog;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class InventoryLogResource extends Resource
{
    protected static ?string $model = InventoryLog::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationLabel = 'تاریخچه موجودی';

    protected static ?string $modelLabel = 'تاریخچه';

    protected static ?string $pluralModelLabel = 'تاریخچه موجودی';

    protected static string|null|UnitEnum $navigationGroup = 'انبار';

    public static function form(Schema $schema): Schema
    {
        return InventoryLogForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InventoryLogsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInventoryLogs::route('/'),
            'create' => CreateInventoryLog::route('/create'),
            'edit' => EditInventoryLog::route('/{record}/edit'),
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

