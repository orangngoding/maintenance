<?php

namespace App\Filament\Resources\BorrowResource\Pages;

use App\Filament\Resources\BorrowResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;

class ListBorrows extends ListRecords
{
    protected static string $resource = BorrowResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'Active' => Tab::make()
                ->modifyQueryUsing(function ($query) {
                    return $query->whereHas('itemBorrows', function ($q) {
                        $q->where('borrow_state', 'active');
                    });
                })
                ->badge(function () {
                    return static::getModel()::whereHas('itemBorrows', function ($q) {
                        $q->where('borrow_state', 'active');
                    })->count();
                }),
            'Pending' => Tab::make()
                ->modifyQueryUsing(function ($query) {
                    return $query->whereHas('itemBorrows', function ($q) {
                        $q->where('borrow_state', 'pending');
                    });
                })
                ->badge(function () {
                    return static::getModel()::whereHas('itemBorrows', function ($q) {
                        $q->where('borrow_state', 'pending');
                    })->count();
                }),
            'Finished' => Tab::make()
                ->modifyQueryUsing(function ($query) {
                    return $query->whereHas('itemBorrows', function ($q) {
                        $q->where('borrow_state', 'finish');
                    });
                })
                ->badge(function () {
                    return static::getModel()::whereHas('itemBorrows', function ($q) {
                        $q->where('borrow_state', 'finish');
                    })->count();
                }),
        ];
    }
}
