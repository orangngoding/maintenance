<?php

namespace App\Filament\Resources\BorrowResource\RelationManagers;

use App\Models\Item;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('item_name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('item_name')
            ->columns([
                Tables\Columns\TextColumn::make('item_code')
                    ->label('Item Code')
                    ->sortable(),
                Tables\Columns\TextColumn::make('item_state')
                    ->label('Item Status')
                    ->badge()
                    ->colors([
                        'primary' => 'available',
                        'danger' => 'unavailable',
                    ]),
                Tables\Columns\TextColumn::make('pivot.borrow_state')
                    ->label('Borrow State')
                    ->badge()
                    ->colors([
                        'primary' => 'pending',
                        'success' => 'active',
                        'warning' => 'finish',
                        'danger' => 'declined',
                    ]),
            ])
            ->filters([
                //
            ])
            ->headerActions([

            ])
            ->actions([
                Action::make('activate')
                    ->label('Activate')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(function ($record) {
                        $record->pivot->update(['borrow_state' => 'active']);
                        Item::where('id', $record->id)->update(['item_state' => 'unavailable']);
                    })
                    ->visible(fn ($record) => $record->pivot->borrow_state === 'pending'),

                Action::make('decline')
                    ->label('Decline')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->action(function ($record) {
                        $record->pivot->update(['borrow_state' => 'declined']);
                    })
                    ->visible(fn ($record) => $record->pivot->borrow_state === 'pending'),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
