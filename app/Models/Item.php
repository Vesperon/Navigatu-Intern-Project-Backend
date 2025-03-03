<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    //
    protected $table = 'property';
    protected $fillable = [
        'item',
        'category',
        'quantity', 
        'tbi_assigned',
        'unit',
        'description',
        'property_num',
        'serial_num',
        'set_items'
    ];

    protected $primaryKey = 'item_id';

    protected $casts = [
        'set_items' => 'array'
    ];

    public function borrow(): HasMany{
        return this->hasMany(Borrow::class, 'item_id');
    }


}
