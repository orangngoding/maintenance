<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItemBorrowResource\Pages;
use App\Models\ItemBorrow;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ItemBorrowResource extends Resource
{
    protected static ?string $model = ItemBorrow::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('item_id'),
                TextColumn::make('borrow_id'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListItemBorrows::route('/'),
            'create' => Pages\CreateItemBorrow::route('/create'),
            'edit' => Pages\EditItemBorrow::route('/{record}/edit'),
        ];
    }
}
