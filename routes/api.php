<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\PartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\BrandController;
use Illuminate\Http\Request;



//Login routes
Route::group([
    'prefix' => 'auth',
], function () {
    Route::post('register', [AuthController::class,'register']);
    Route::post('login', [AuthController::class,'login']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'me']);

});


//admin routes
Route::group(['middleware' => 'admin'], function(){
    Route::get('admin/getUsers', [AdminController::class,'GetUsers']); 
    Route::post('admin/changeUserRole', [AdminController::class,'ChangeUserRole']); 

});



//cars routes
Route::get('car/all', [CarController::class,'AllCar']); 
Route::get('car/getCarDetails/{id}', [CarController::class,'GetCarDetails']);
Route::get('car/getPartsByCar/{id}', [CarController::class,'GetPartsCar']);
Route::get('car/getCarList', [CarController::class,'GetCarList']);
Route::group(['middleware' => 'check.permissions'], function(){
    Route::post('car/add', [CarController::class,'AddCar']);
    Route::put('car/edit/{id}', [CarController::class,'EditCar']);
    Route::delete('car/delete/{id}', [CarController::class,'DeleteCar']);

});

//categories routes
Route::get('categoty/all', [CategoryController::class,'AllCategory']); 
Route::get('categoty/getPartsByCategory', [CategoryController::class,'GetPartsCategory']);
Route::group(['middleware' => 'check.permissions'], function(){
    Route::post('category/add', [CategoryController::class,'AddCategory']);
    Route::put('category/edit/{id}', [CategoryController::class,'EditCategory']);
    Route::delete('category/delete/{id}', [CategoryController::class,'DeleteCategory']);
});


//Parts routes
Route::get('part/all/{orderby}', [PartController::class,'AllPart']); 
Route::group(['middleware' => 'check.permissions'], function(){
    Route::post('part/add', [PartController::class,'AddPart']);
    Route::put('part/edit/{id}', [PartController::class,'EditPart']);
    Route::delete('part/delete/{id}', [PartController::class,'DeletePart']);
});


Route::get('brand/add', [BrandController::class,'add']);
