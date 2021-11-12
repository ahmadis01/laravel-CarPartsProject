<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Country;

class BrandController extends Controller
{
    public function add(){

        $jsondata=file_get_contents('brands.json');
        $obj=json_decode($jsondata,true);
        foreach($obj as $item){
            if(Country::where('name', $item['country'])->exists()){
                $country_id=Country::where('name',$item['country'])->first()->id;
            }else{
                $insert=Country::create(['name' => $item['country']]);
                $country_id = $insert->id;
            }
        $data=Brand::create([
            'name' => $item['name'],
            'logo' => $item['logo'],
            'country_id' => $country_id

        ]);
        }
    }
}
