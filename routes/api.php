<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('item', App\Http\Controllers\ItemController::class);

Route::resource('order', App\Http\Controllers\OrderController::class);

Route::get('cart', [ItemsController::class,'cart']);

Route::delete('cart/{item}', [ItemsController::class,'deleteArticle']);

Route::post('cart/{item}', [ItemsController::class,'ajoutArticle']);
