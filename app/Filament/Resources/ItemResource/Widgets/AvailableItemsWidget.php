<?php

namespace App\Filament\Resources\ItemResource\Widgets;

use App\Filament\Resources\BorrowResource\Pages;
use App\Models\Item;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class AvailableItemsWidget extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn () => Item::where('item_state', 'available'))
            ->columns([
                Tables\Columns\TextColumn::make('item_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('item_name')
                    ->searchable(),

            ]);
    }

    public static function getPages()
    {
        return [
            'createborrow' => Pages\createborrow::route('/create'),
        ];
    }
}
