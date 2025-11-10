<?php

declare(strict_types=1);

namespace Mortezaa97\Inventories\Filament\Resources\Inventories\RelationManagers;

use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InventoryLogsRelationManager extends RelationManager
{
    protected static string $relationship = 'inventoryLogs';

    protected static ?string $title = 'تاریخچه تغییرات';

    protected static ?string $modelLabel = 'تغییر';

    protected static ?string $pluralModelLabel = 'تغییرات';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('count')
                    ->label('تعداد')
                    ->required()
                    ->numeric()
                    ->minValue(1),
                Forms\Components\Select::make('type')
                    ->label('نوع تغییر')
                    ->options([
                        0 => 'افزایش',
                        1 => 'کاهش',
                    ])
                    ->required()
                    ->default(0),
                Forms\Components\Select::make('model_type')
                    ->label('نوع مدل')
                    ->options([
                        'App\\Models\\Factor' => 'فاکتور',
                        'App\\Models\\FactorHasItem' => 'آیتم فاکتور',
                    ])
                    ->searchable(),
                Forms\Components\TextInput::make('model_id')
                    ->label('شناسه مدل')
                    ->numeric(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('count')
                    ->label('تعداد')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('type')
                    ->label('نوع تغییر')
                    ->badge()
                    ->color(fn (bool $state): string => $state ? 'danger' : 'success')
                    ->formatStateUsing(fn (bool $state): string => $state ? 'کاهش' : 'افزایش'),
                TextColumn::make('model_type')
                    ->label('نوع مدل')
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'App\\Models\\Factor' => 'فاکتور',
                        'App\\Models\\FactorHasItem' => 'آیتم فاکتور',
                        default => $state ?? '-',
                    })
                    ->toggleable(),
                TextColumn::make('model_id')
                    ->label('شناسه مدل')
                    ->toggleable(),
                TextColumn::make('createdBy.name')
                    ->label('ایجاد شده توسط')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('تاریخ ایجاد')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('نوع تغییر')
                    ->options([
                        0 => 'افزایش',
                        1 => 'کاهش',
                    ]),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['created_by'] = auth()->id();
                        $data['updated_by'] = auth()->id();
                        return $data;
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['updated_by'] = auth()->id();
                        return $data;
                    }),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]))
            ->defaultSort('created_at', 'desc');
    }
}
