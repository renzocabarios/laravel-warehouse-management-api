<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\ShipmentItemController;
use App\Http\Controllers\BranchOwnerController;
use App\Http\Controllers\AdminController;



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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::apiResource('/item', ItemController::class);
Route::apiResource('/branch', BranchController::class);
Route::apiResource('/stock', StockController::class);
Route::apiResource('/user', UserController::class);
Route::apiResource('/vehicle', VehicleController::class);
Route::apiResource('/shipment', ShipmentController::class);
Route::apiResource('/shipmentitem', ShipmentItemController::class);
Route::apiResource('/branch-owner', BranchOwnerController::class);
Route::apiResource('/admin', AdminController::class);