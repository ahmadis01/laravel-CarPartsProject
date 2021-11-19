<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\PartController;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Car;
use App\Models\Part;
use App\Models\Country;


class CarController extends Controller
{
    public function AllCars()
    {
        $cars = Car::all();
        return response()->json($cars);
    }
    
    public function AddCar(request $request)
    {
        if(Country::where('name', $request->country)->exists()){
            $country_id=Country::where('name',$request->country)->first()->id;
        }else{
            $insert=Country::create(['name' => $request->country]);
            $country_id = $insert->id;
        }

        if ($request->image) {
            $image = $request->file('image');
            $gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $image->move('images/car/', $gen);
            $last = 'images/car/' . $gen;
            $data = Car::create([
                'maker' => $request->maker,
                'name' => $request->name,
                'image' =>    $last,
                'model' => $request->model,
                'partsCount' => 0,
                'country_id' => $country_id
            ]);
            Car::find($data->id)->update(['partsCount' => PartController::partsCount($data->id)]);
        } else {
            
            $data = Car::create([
                'maker' => $request->maker,
                'name' => $request->name,
                'model' => $request->model,
                'partsCount' => 0,
                'country_id' => $country_id
            ]);
            Car::find($data->id)->update(['partsCount' => PartController::partsCount($data->id)]);
        }
        return response()->json($data);
    }
    public function GetCarList()
    {
        
        $cars_list = Car::select('id', 'name')->get();
        return response()->json($cars_list);
    }
    public function GetCarDetails($id)
    {
        
        $car = Car::where('id', $id)->get();
        return response()->json($car);
    }
    public function EditCar(request $request, $id)
    {
        $partsCount = Car::find($id)->update(['partsCount' => PartController::partsCount($id)]);;
        if ($request->image) {
            $oldimage = Car::find($id)->image;
            if ($oldimage != 'images/car/default.png')
                unlink($oldimage);
            $newimage = $request->file('image');
            $gen = hexdec(uniqid()) . '.' . $newimage->getClientOriginalExtension();
            $newimage->move('images/car/', $gen);
            $last = 'images/car/' . $gen;
            Car::find($id)->update([
                'maker' => $request->maker,
                'name' => $request->name,
                'model' => $request->model,
                'image' => $last,
                'country' => $request->country,
                'partsCount' => $partsCount,
                'updated_at' => Carbon::now(),
            ]);
        } else {
            Car::find($id)->update([
                'maker' => $request->maker,
                'name' => $request->name,
                'model' => $request->model,
                'country' => $request->country,
                'partsCount' => $partsCount,
                'updated_at' => Carbon::now(),
            ]);
        }

        return response()->json('success');
    }
    public function DeleteCar($id)
    {
        $car = Car::find($id);
        Car::find($id)->delete();
        if ($car->image != 'images/car/default.png')
            unlink($car->image);

        return 'succes';
    }
    public function GetPartsCar($id)
    {
        $parts = Car::find($id)->parts()->latest()->get();
        return response()->json($parts);
    }
}
