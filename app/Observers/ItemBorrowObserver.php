<?php

namespace App\Observers;

use App\Models\Item;
use App\Models\ItemBorrow;

class ItemBorrowObserver
{
    public function attached(ItemBorrow $itemBorrow, $item_ids) {}

    /**
     * Handle the ItemBorrow "created" event.
     */
    public function created(ItemBorrow $itemBorrow): void
    {
        Item::where('id', $itemBorrow->item_id)->update(['item_state' => 'unavailable']);
    }

    /**
     * Handle the ItemBorrow "updated" event.
     */
    public function updated(ItemBorrow $itemBorrow): void {}

    /**
     * Handle the ItemBorrow "deleted" event.
     */
    public function deleted(ItemBorrow $itemBorrow): void
    {
        //
    }

    /**
     * Handle the ItemBorrow "restored" event.
     */
    public function restored(ItemBorrow $itemBorrow): void
    {
        //
    }

    /**
     * Handle the ItemBorrow "force deleted" event.
     */
    public function forceDeleted(ItemBorrow $itemBorrow): void
    {
        //
    }
}
