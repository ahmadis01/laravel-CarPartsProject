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
            $country_id=Country::firstOrCreate([
                'name' => $item['country'],
            ])->id;
        $data=Brand::create([
            'name' => $item['name'],
            'logo' => $item['logo'],
            'country_id' => $country_id

        ]);
        
        }
    }
}
