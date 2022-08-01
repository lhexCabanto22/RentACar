<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\OfficeController;
use App\Http\Controllers\Api\RentController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\NotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login']);
// Route::middleware('auth:api')->group( function () {
    
  
// });
Route::group( ['middleware' => ['auth:api'] ],function(){

    Route::resource('/user', UserController::class);
     Route::resource('/role', RoleController::class);
      Route::resource('/office', OfficeController::class);
       Route::resource('/car', CarController::class);
        Route::resource('/brand', BrandController::class);
         Route::resource('/rent', RentController::class);
          Route::resource('/customer', CustomerController::class);
        
/*RENT*/
Route::get('/car_display', [RentController::class, 'display']);
Route::put('/updateStatus/{id}', [RentController::class, 'updateStatus']);
/*CAR*/
Route::put('/updateCarStatus/{id}', [CarController::class, 'updateCarStatus']);

Route::get('/rentToday', [NotificationController::class, 'rentToday']);
Route::get('/returnToday', [NotificationController::class, 'returnToday']);

});


Route::middleware('auth:user-api')->get('/users', function (Request $request) {
        return $request->user();
    });
    

