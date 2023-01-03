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
use App\Http\Controllers\AuthController;



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

Route::middleware(['auth:api'])->group(function () {
    Route::apiResource('/item', ItemController::class);
    Route::apiResource('/branch', BranchController::class);
    Route::apiResource('/stock', StockController::class);
    Route::apiResource('/user', UserController::class);
    Route::apiResource('/vehicle', VehicleController::class);
    Route::apiResource('/shipment', ShipmentController::class);
    Route::apiResource('/shipment-item', ShipmentItemController::class);
    Route::apiResource('/branch-owner', BranchOwnerController::class, ['except' => ['store']]);
    Route::apiResource('/admin', AdminController::class);
    Route::patch('/shipment/{id}/approve', [ShipmentController::class, 'approve']);
});

Route::post('/auth', [AuthController::class, "login"]);
Route::post('/branch-owner', [BranchOwnerController::class, "store"]);