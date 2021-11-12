<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Car extends Model
{
    use HasFactory;
    protected $fillable =[
        'maker',
        'name',
        'image',
        'model',
        'country_id',
        'partsCount'

    ];
    
    public function parts(){
        return $this->belongsToMany(Part::class,'car_parts');
    }
}
