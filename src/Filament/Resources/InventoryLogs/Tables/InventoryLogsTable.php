<?php

declare(strict_types=1);

namespace Mortezaa97\Inventories\Filament\Resources\InventoryLogs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;

class InventoryLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('inventory.name')
                    ->label('موجودی')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('count')
                    ->label('تعداد')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('type')
                    ->label('نوع تغییر')
                    ->badge()
                    ->color(fn (bool $state): string => $state ? 'danger' : 'success')
                    ->formatStateUsing(fn (bool $state): string => $state ? 'کاهش' : 'افزایش'),
                TextColumn::make('model_id')
                    ->label('کالا/جنس/محصول')
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->model_type === \App\Enums\ModelType::PRODUCT->value && $record->model_id) {
                            $product = \Mortezaa97\Shop\Models\Product::find($record->model_id);
                            return $product?->name ?? $state;
                        }
                        return $state;
                    })
                    ->toggleable(),
                \App\Filament\Components\Table\CreatedByTextColumn::create(),
                \App\Filament\Components\Table\UpdatedByTextColumn::create()
                    ->toggleable(isToggledHiddenByDefault: true),
                \App\Filament\Components\Table\DeletedAtTextColumn::create()
                    ->toggleable(isToggledHiddenByDefault: true),
                \App\Filament\Components\Table\CreatedAtTextColumn::create(),
                \App\Filament\Components\Table\UpdatedAtTextColumn::create()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
                SelectFilter::make('type')
                    ->label('نوع تغییر')
                    ->options([
                        0 => 'افزایش',
                        1 => 'کاهش',
                    ]),
                SelectFilter::make('inventory')
                    ->label('موجودی')
                    ->relationship('inventory', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()->iconButton()->tooltip('ویرایش'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}

