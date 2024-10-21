<?php

namespace App\Filament\Resources\CategoryItemResource\Pages;

use App\Filament\Resources\CategoryItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCategoryItem extends EditRecord
{
    protected static string $resource = CategoryItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
