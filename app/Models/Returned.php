<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Returned extends Model
{
    //

    protected $table = 'returned';
    protected $fillable = [
        'borrow_id',
        'item',
        'quantity',
        'office',
        'person',
        'purpose'
    ];

    protected $primaryKey = 'returned_id';

    public function borrow(): BelongsTo{
        return this->belongsTo(Borrow::class, 'borrow_id');
    }
}
