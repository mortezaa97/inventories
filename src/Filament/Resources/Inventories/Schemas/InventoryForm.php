<?php

declare(strict_types=1);

namespace Mortezaa97\Inventories\Filament\Resources\Inventories\Schemas;

use Filament\Schemas\Schema;

class InventoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            \Filament\Schemas\Components\Group::make()
                ->schema([
                    \Filament\Schemas\Components\Section::make()
                        ->schema([
                            \Filament\Forms\Components\TextInput::make('name')
                                ->translateLabel()
                                ->label('نام انبار')
                                ->required()
                                ->maxLength(255)
                                ->columnSpan(6),
                            \Filament\Forms\Components\TextInput::make('count')
                                ->translateLabel()
                                ->label('ظرفیت انبار')
                                ->required()
                                ->numeric()
                                ->default(0)
                                ->minValue(0)
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

