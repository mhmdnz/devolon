<?php

use App\Http\Controllers\Offer\OfferCreateController;
use App\Http\Controllers\Offer\OfferDeleteController;
use App\Http\Controllers\Offer\OfferShowController;
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

Route::post('/product/{product}/offer', OfferCreateController::class);

Route::get('/product/{product}/offers', OfferShowController::class);

Route::delete('/product/{product}/offer/{offer}', OfferDeleteController::class);
