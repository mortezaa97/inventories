<?php

declare(strict_types=1);

namespace Mortezaa97\Inventories\Filament\Resources\InventoryLogs\Schemas;

use App\Enums\ModelType;
use Mortezaa97\Inventories\Models\Inventory;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;

class InventoryLogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            \Filament\Schemas\Components\Group::make()
                ->schema([
                    \Filament\Schemas\Components\Section::make()
                        ->schema([
                            Select::make('inventory_id')
                                ->label('انبار')
                                ->relationship('inventory', 'name')
                                ->required()
                                ->searchable()
                                ->preload()
                                ->columnSpan(6),
                            \Filament\Forms\Components\TextInput::make('count')
                                ->translateLabel()
                                ->label('تعداد')
                                ->required()
                                ->numeric()
                                ->minValue(1)
                                ->columnSpan(6),
                            Select::make('type')
                                ->label('نوع تغییر')
                                ->options([
                                    0 => 'افزایش',
                                    1 => 'کاهش',
                                ])
                                ->required()
                                ->default(0)
                                ->columnSpan(6),
                            Select::make('model_type')
                                ->label('نوع مدل')
                                ->options([
                                    ModelType::PRODUCT->value => 'محصول',
                                ])
                                ->live()
                                ->searchable()
                                ->columnSpan(6),
                            Select::make('model_id')
                                ->label('شناسه مدل')
                                ->options(function (callable $get) {
                                    $modelType = $get('model_type');
                                    if ($modelType === ModelType::PRODUCT->value) {
                                        return \Mortezaa97\Shop\Models\Product::pluck('name', 'id');
                                    }
                                    return [];
                                })
                                ->live()
                                ->searchable()
                                ->required()
                                ->visible(fn (callable $get) => filled($get('model_type')))
                                ->columnSpan(6),
                        ])
                        ->columns(12)
                        ->columnSpan(12),
                ])
                ->columns(12)
                ->columnSpan(8),
            \Filament\Schemas\Components\Group::make()
                ->schema([
                    \Filament\Schemas\Components\Section::make()
                        ->schema([
                            
                            \App\Filament\Components\Form\CreatedByHidden::create()
                                ->required()
                                ->columnSpan(6),
                            \App\Filament\Components\Form\UpdatedByHidden::create()
                                ->columnSpan(6),
                        ])
                        ->columns(12)
                        ->columnSpan(12),
                ])
                ->columns(12)
                ->columnSpan(4),
        ])
            ->columns(12);
    }
}

