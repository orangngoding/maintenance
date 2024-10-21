<?php

namespace App\Filament\Resources\ItemBorrowResource\Pages;

use App\Filament\Resources\ItemBorrowResource;
use App\Models\Item;
use Filament\Resources\Pages\CreateRecord;

class CreateItemBorrow extends CreateRecord
{
    protected static string $resource = ItemBorrowResource::class;

    protected function afterCreate()
    {
        Item::where('id', '=', $this->record->item_id)->update(['item_state' => 0]);
    }
}
