<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'borrow_name',
        'borrow_start',
        'borrow_finish',
        'borrow_status',
    ];

    public function Items()
    {
        return $this->belongsToMany(Item::class, 'item_borrows')
            ->withPivot('borrow_state');
    }

    public function itemBorrows()
    {
        return $this->hasMany(ItemBorrow::class);
    }

    public function setBorrowStatusAttribute($value)
    {
        // // $this->attributes['borrow_status'] = $value;
        // if ($value === 'pending') {
        //     $this->Items->update(['item_state' => 0]);
        // } elseif ($value === 'finish') {
        //     $this->Items->update(['item_state' => 1]);
        // }
    }

    public static function booted()
    {
        static::creating(function ($model) {
            // $item = Item::find($model->item_id);
            // $model->borrow_status = 'pending';
            // $item->update(['item_state' => 'unavailable']);
        });
    }
}
