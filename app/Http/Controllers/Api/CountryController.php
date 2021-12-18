<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
class CountryController extends Controller
{
    public function AllCountries(){
        $countries=Country::allCountry();
        return response()->json($countries);
    }
    public function ShowCountry(request $request ,$id){
        $country=Country::find($id)->get();
        return response()->json($country);
    }
    
}
