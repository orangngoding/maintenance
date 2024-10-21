<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemBorrow extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'borrow_id',
    ];

    public static function booted()
    {
        static::creating(function ($model) {
            $model->borrow_status = 'pending';
            $item = Item::find($model->item_id);
            $item->update('item_state', 'unavailable');
        });
    }
}
