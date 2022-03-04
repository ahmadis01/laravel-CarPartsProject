<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Part;
use App\Models\Car;
use App\Models\Country;
use App\Models\CarPart;
use App\Models\Category;
use App\Http\Controllers\Api\CategoryController;

use Carbon\Carbon;

class PartController extends Controller
{
    public static function partsCount($carid)
    {
        $totalquantity = 0;
        $ids = Car::find($carid)->parts;

            foreach ($ids as $id)
                $totalquantity += $id->quantity;

        return $totalquantity;
    }
    public function AllParts($orderby)
    {
        if($orderby == 'newest')
        {
            $parts = Part::latest()->get();
            return response()->json($parts);

        } else if($orderby == 'oldest') {

            $parts = Part::all();
            return response()->json($parts);

        } else if($orderby == 'byname'){
            $parts = Part::orderBy('name')->get();
            return response()->json($parts);
        } else if($orderby == 'byprice'){

            $parts = Part::orderBy('sellingPrice')->get();
            return response()->json($parts);

        } else if($orderby == 'bymaker'){

            $parts = Part::orderBy('maker')->get();
            return response()->json($parts);

        }else if($orderby == 'byquantity'){

            $parts = Part::orderBy('quantity')->get();
            return response()->json($parts);

        }else if($orderby == 'bycountry'){

            $parts = Part::orderBy('country')->get();
            return response()->json($parts);

        }else if($orderby == 'bycategory'){

            $parts = Part::orderBy('category_id')->get();
            return response()->json($parts);

        }else if($orderby == 'bycar'){
            $parts = Part::orderBy('car_id')->get();
            return response()->json($parts);
        }
    }
    public function ShowPart(request $request , $id){
        $part=Part::find($id)->get();
        return response($part);
    }
    public function AddPart(request $request)
    {
        $country_id=Country::firstOrCreate([
            'name' => $request->country,
        ])->id;
        
        if ($request->image) {
            $image = $request->file('image');
            $gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $image->move('images/part/', $gen);
            $last = 'images/part/' . $gen;
            $data = Part::create([
                'maker' => $request->maker,
                'name' => $request->name,
                'image' =>    $last,
                'description' => $request->description,
                'quantity' => $request->quantity,
                'orginalPrice' => $request->orginalPrice,
                'sellingPrice' => $request->sellingPrice,
                'category_id' => $request->category_id,
                'country_id' => $country_id
            ]);
            CarPart::create([
                'car_id' => $request->car_id,
                'part_id' => $data->id,
            ]);

        } else {
            $data = Part::create([
                'maker' => $request->maker,
                'name' => $request->name,
                'description' => $request->description,
                'quantity' => $request->quantity,
                'orginalPrice' => $request->orginalPrice,
                'sellingPrice' => $request->sellingPrice,
                'category_id' => $request->category_id,
                'country_id' => $country_id
            ]);
            $data2= CarPart::create([
                'car_id' => $request->car_id,
                'part_id' => $data->id,
            ]);
        }

        Category::find($request->category_id)->update(['partsCount' => CategoryController::partsCount($request->category_id)]);
        Car::find($request->car_id)->update(['partsCount' => PartController::partsCount($request->car_id)]);
        return response()->json($data);
    }
    public function EditPart(request $request, $id)
    {
        if ($request->image) {
            $oldimage = Part::find($id)->image;
            if ($oldimage != 'images/part/default.png')
                unlink($oldimage);
            $newimage = $request->file('image');
            $gen = hexdec(uniqid()) . '.' . $newimage->getClientOriginalExtension();
            $newimage->move('images/part/', $gen);
            $last = 'images/part/' . $gen;
            $Part = Part::find($id)->update([
                'name' => $request->name,
                'maker' => $request->maker,
                'description' => $request->description,
                'country' => $request->country,
                'image' => $last,
                'quantity' => $request->quantity,
                'orginalPrice' => $request->orginalPrice,
                'sellingPrice' => $request->sellingPrice,
                'category_id' => $request->category_id,
                'car_id' => $request->car_id,
                'updated_at' => Carbon::now()
            ]);
        } else {
            $Part = Part::find($id)->update([
                'name' => $request->name,
                'maker' => $request->maker,
                'description' => $request->description,
                'country' => $request->country,
                'quantity' => $request->quantity,
                'orginalPrice' => $request->orginalPrice,
                'sellingPrice' => $request->sellingPrice,
                'category_id' => $request->category_id,
                'car_id' => $request->car_id,
                'updated_at' => Carbon::now()
            ]);
        }
        return response()->json('succes');
    }
    public function DeletePart(request $request, $id)
    {
        $part = Part::find($id);
        if ($part->image != 'images/part/defaultpart')
            unlink($part->image);
        $part->delete();
    }

}
