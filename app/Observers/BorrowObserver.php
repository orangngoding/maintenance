<?php

namespace App\Observers;

use App\Models\Borrow;
use App\Models\Item;

class BorrowObserver
{
    /**
     * Handle the Borrow "created" event.
     */
    public function created(Borrow $borrow): void
    {
        $itemIds = $borrow->items->pluck('id')->toArray();
        Item::whereIn('id', $itemIds)->update(['item_state' => 0]);
    }

    /**
     * Handle the Borrow "updated" event.
     */
    public function updated(Borrow $borrow): void
    {
        // if ($borrow->borrow_status === 'finish') {
        //     foreach ($borrow->Items as $item) {
        //         $item->update(['item_state' => 1]);
        //     }
        // }
    }

    /**
     * Handle the Borrow "deleted" event.
     */
    public function deleted(Borrow $borrow): void
    {
        //
    }

    /**
     * Handle the Borrow "restored" event.
     */
    public function restored(Borrow $borrow): void
    {
        //
    }

    /**
     * Handle the Borrow "force deleted" event.
     */
    public function forceDeleted(Borrow $borrow): void
    {
        //
    }
}
