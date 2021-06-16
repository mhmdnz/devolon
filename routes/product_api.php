<?php

use App\Http\Controllers\Product\ProductCreateController;
use App\Http\Controllers\Product\ProductDeleteController;
use App\Http\Controllers\Product\ProductInsertController;
use App\Http\Controllers\Product\ProductShowController;
use App\Http\Controllers\Product\ProductUpdateController;
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

Route::post('/product', ProductCreateController::class);

Route::post('/products', ProductInsertController::class);

Route::delete('/product/{product}', ProductDeleteController::class);

Route::put('/product/{product}', ProductUpdateController::class);

Route::get('/product/{product}', ProductShowController::class);
