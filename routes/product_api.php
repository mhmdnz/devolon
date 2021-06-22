<?php

use App\Http\Controllers\Product\ProductCreateController;
use App\Http\Controllers\Product\ProductDeleteController;
use App\Http\Controllers\Product\ProductUpsertController;
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

Route::post('/products', ProductCreateController::class);

Route::delete('/products/{product}', ProductDeleteController::class);

Route::put('/products/{product}', ProductUpdateController::class);

Route::get('/products/{product}', ProductShowController::class);
