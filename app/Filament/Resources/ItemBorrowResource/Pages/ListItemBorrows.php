<?php

namespace App\Filament\Resources\ItemBorrowResource\Pages;

use App\Filament\Resources\ItemBorrowResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ListItemBorrows extends ListRecords
{
    protected static string $resource = ItemBorrowResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    // protected function getTabs(): array{
    //     return [
    //         'All' => Tab::make(),
    //         'Borrowed' =>Tab::make()->modifyQueryUsing(function (Builder $query){
    //             $query = Item::whereBelongsTo();
    //         })
    //     ];
    // }
}
