<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    //

    protected $table = 'logs';
    protected $fillable = [
        'reference_id',
        'item',
        'quantity',
        'office',
        'person',
        'purpose',
        'status'
    ];

    protected $primaryKey = 'id';
}
