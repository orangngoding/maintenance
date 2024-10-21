<?php

namespace App\Filament\Resources\ItemBorrowResource\Widgets;

use App\Models\ItemBorrow;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ItemBorrowView extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            // ->query(ItemBorrow::latest())
            ->columns([
                // TextColumn::make('items.item_name'),
            ]);
    }
}
