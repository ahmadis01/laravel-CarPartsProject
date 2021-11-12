<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory;
    protected $fillable = [
        'name' ,
        'maker' ,
        'country_id' ,
        'image' ,
        'description' ,
        'quantity' ,
        'sellingPrice' ,
        'orginalPrice' ,
        'category_id' ,
    ];
   
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function cars(){
        return $this->belongsToMany(Car::class,'car_parts');
    }
}
