<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_item_id',
        'item_code',
        'item_name',
        'item_state',
    ];

    public function CategoryItem()
    {
        return $this->belongsTo(CategoryItem::class);
    }

    public function Borrows()
    {
        return $this->belongsToMany(Borrow::class, 'item_borrows')
            ->withPivot('borrow_state');
    }

    public function setStatItemAttribute($value)
    {
        $this->attributes['item_state'] = $value ? 1 : 0;
    }

    public function getStatItemAttribute($value)
    {
        return $value ? 'Available' : 'Unavailable';
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $category = CategoryItem::find($model->category_item_id);

            $singcat = strtoupper(substr($category->category_name, 0, 3));
            $sumitemcat = Item::where('category_item_id', $model->category_item_id)->count() + 1;
            $model->item_code = $singcat.'-'.str_pad($sumitemcat, 3, '0', STR_PAD_LEFT);
        });
    }
}
