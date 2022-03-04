<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable =[
        'customer_id',
        'selling_time',
        'selling_date',
        'total_price',

    ];
    public function parts(){
        return $this->belongsToMany(Part::class,'order_parts');
    }
}
