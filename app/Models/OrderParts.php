<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderParts extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'part_id',
        'quantity'
    ];
}
