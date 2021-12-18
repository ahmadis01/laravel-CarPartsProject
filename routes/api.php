<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\PartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\AdminController;
use Illuminate\Http\Request;


//Login routes
    Route::group([
        'prefix' => 'auth',
    ], function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('me', [AuthController::class, 'me']);

    });


//admin routes
    Route::group(['middleware' => 'admin'], function () {
        Route::get('admin/getUsers', [AdminController::class, 'GetUsers']);
        Route::post('admin/changeUserRole/{id}', [AdminController::class, 'ChangeUserRole']);

    });


//cars routes
    Route::get('car/all', [CarController::class, 'AllCars']);
    Route::get('car/getCarDetails/{id}', [CarController::class, 'GetCarDetails']);
    Route::get('car/getPartsByCar/{id}', [CarController::class, 'GetPartsCar']);
    Route::get('car/getCarList', [CarController::class, 'GetCarList']);
    Route::group(['middleware' => 'check.permissions'], function () {
        Route::post('car/add', [CarController::class, 'AddCar']);
        Route::put('car/edit/{id}', [CarController::class, 'EditCar']);
        Route::delete('car/delete/{id}', [CarController::class, 'DeleteCar']);

    });

//categories routes
    Route::get('category/all', [CategoryController::class, 'AllCategory']);
    Route::get('category/getPartsByCategory', [CategoryController::class, 'GetPartsCategory']);
    Route::group(['middleware' => 'check.permissions'], function () {
        Route::post('category/add', [CategoryController::class, 'AddCategory']);
        Route::put('category/edit/{id}', [CategoryController::class, 'EditCategory']);
        Route::delete('category/delete/{id}', [CategoryController::class, 'DeleteCategory']);
    });


//Parts routes
    Route::get('part/all/{orderby}', [PartController::class, 'AllParts']);
    Route::get('part/getPartDetails/{id}', [PartController::class, 'ShowPart']);
    Route::group(['middleware' => 'check.permissions'], function () {
        Route::post('part/add', [PartController::class, 'AddPart']);
        Route::put('part/edit/{id}', [PartController::class, 'EditPart']);
        Route::delete('part/delete/{id}', [PartController::class, 'DeletePart']);
    });


//country routes
    Route::get('country/all', [CountryController::class, 'AllCountries']);
    Route::get('country/show/{id}', [CountryController::class, 'ShowCountry']);

    Route::get('brand/add', [BrandController::class, 'add']);
