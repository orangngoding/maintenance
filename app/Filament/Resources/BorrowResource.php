<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BorrowResource\Pages;
use App\Filament\Resources\BorrowResource\RelationManagers\ItemsRelationManager;
use App\Models\Borrow;
use App\Models\Item;
use App\Models\ItemBorrow;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class BorrowResource extends Resource
{
    protected static ?string $model = Borrow::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $buttonLabel = 'Borrow';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('borrow_name')
                    ->default(fn () => auth()->user()->name)
                    ->disabled()
                    ->dehydrated(),
                DatePicker::make('borrow_start')
                    ->format('d M Y')
                    ->default(now()),
                Select::make('item_id')
                    ->multiple()
                    ->preload()
                    ->relationship('items', 'item_name')
                    ->options(function () {
                        return Item::where('item_state', 'available')->pluck('item_name', 'id');
                    }),
                // Select::make('borrow_status')
                //     ->options([
                //         'pending',
                //         'active',
                //         'finish',
                //     ])
                //     ->default('pending'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('borrow_name'),
                TextColumn::make('items.item_code')
                    ->label('Borrowed Items')
                    ->formatStateUsing(function ($state, Borrow $record) {
                        return $record->items->pluck('item_code')->implode(', ');
                    }),
                TextColumn::make('borrow_start')
                    ->date('d M Y'),
                TextColumn::make('borrow_finish')
                    ->date('d M Y'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('finish')
                    ->label('Finish Borrow')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(function (Borrow $record) {
                        DB::transaction(function () use ($record) {
                            $record->update([
                                'borrow_finish' => now(),
                            ]);
                            $record->items()->update(['item_state' => 'available']); // 1 represents available
                            $record->itemBorrows()->update(['borrow_state' => 'finish']);
                        });
                    })
                    ->requiresConfirmation()
                    ->visible(fn (Borrow $record) => $record->itemBorrows()->where('borrow_state', 'active')->exists()),
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make()
                        ->exports([
                            ExcelExport::make('table')->fromTable(),
                        ]),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBorrows::route('/'),
            'create' => Pages\CreateBorrow::route('/create'),
            'edit' => Pages\EditBorrow::route('/{record}/edit'),
        ];
    }

    public static function afterCreate(Borrow $borrow): void
    {
        $itemIds = $borrow->items->pluck('id')->toArray();

        // Update item_state to 0 for all selected items
        Item::whereIn('id', $itemIds)->update(['item_state' => 'unavailable']);

        // Create ItemBorrow records
        foreach ($itemIds as $itemId) {
            ItemBorrow::create([
                'borrow_id' => $borrow->id,
                'item_id' => $itemId,
            ]);
        }
    }
}
