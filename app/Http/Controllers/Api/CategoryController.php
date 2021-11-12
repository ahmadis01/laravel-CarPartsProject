<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Part;
use Illuminate\Support\Carbon;

class CategoryController extends Controller
{
    public static function partsCount($categoryid)
    {
        $parts = Part::where('category_id', $categoryid)->get();
        $totalquantity = 0;
        foreach ($parts as $part)
            $totalquantity += $part->quantity;
        return $totalquantity;
    }
    public function AllCategory()
    {
        $categories = Category::all();
        return response()->json($categories);
    }
    public function AddCategory(request $request)
    {
        if ($request->image) {
            $image = $request->file('image');
            $image_name = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $last = 'images/categories/' . $image_name;
            $category = Category::create([
                'name' => $request->name,
                'image' => $last,
                'partsCount' => 0,
                'created_at' => Carbon::now(),
            ]);
            Category::find($category->id)->update(['partsCount' => CategoryController::partsCount($category->id)]);
        } else {
            $category = Category::create([
                'name' => $request->name,
                'partsCount' => 0,
                'created_at' => Carbon::now(),
            ]);
            Category::find($category->id)->update(['partsCount' => CategoryController::partsCount($category->id)]);

        }

        return response()->json($category);
    }
    public function EditCategory(request $request, $id)
    {
        if ($request->image) {
            $oldimage = Category::find($id)->image;
            if ($oldimage != 'images/category/default.png')
                unlink($oldimage);
            $newimage = $request->file('image');
            $gen = hexdec(uniqid()) . '.' . $newimage->getClientOriginalExtension();
            $newimage->move('images/category/', $gen);
            $last = 'images/category/' . $gen;
            $category = Category::find($id)->update([
                'name' => $request->name,
                'image' => $last,
                'part_id' => $request->car_id,
                
            ]);
        } else {
            $category = Category::find($id)->update([
                'name' => $request->name,
                'part_id' => $request->car_id,

            ]);
        }
        return response()->json('succes');
    }
    public function DeleteCategory(request $request, $id)
    {
        $category = Category::find($id);
        if ($category->image != 'images/category/default.png')
            unlink($category->image);
        $category->delete();
        return response()->json('succes');
    }
    public function GetPartsCategory($id)
    {
        $parts = Category::find($id)->parts()->latest()->get();
        return response()->json($parts);
    }
}
