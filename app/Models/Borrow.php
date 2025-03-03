<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    //

    protected $table = 'borrow';
    protected $fillable = [
        'item_id',
        'item', 
        'category',
        'expected_return',
        'quantity', 
        'office', 
        'person', 
        'purpose'
    ];

    protected $primaryKey = 'borrow_id';
    


    public function item(): BelongsTo{
        return this->belongsTo(Item::class, 'item_id');
    }

    public function returnd(): HasOne{
        return this->hasOne(Returned::class, 'borrow_id');
    }
}
