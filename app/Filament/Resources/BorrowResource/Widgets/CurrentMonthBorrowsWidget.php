<?php

namespace App\Filament\Resources\BorrowResource\Widgets;

use App\Models\Borrow;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class CurrentMonthBorrowsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $currentMonth = Borrow::whereMonth('created_at', '=', now()->month)->count();

        return [
            StatsOverviewWidget\Stat::make('Current Month Borrows', $currentMonth),
        ];
    }
}
