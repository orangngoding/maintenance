<?php

namespace App\Filament\Resources\ItemBorrowResource\Pages;

use App\Filament\Resources\ItemBorrowResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditItemBorrow extends EditRecord
{
    protected static string $resource = ItemBorrowResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
