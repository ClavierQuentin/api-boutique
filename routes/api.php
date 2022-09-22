<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Api\AuthController;

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

Route::resource('order', OrderController::class)->middleware('auth:sanctum');

Route::get('buy', [OrderController::class, 'validateOrder'])->middleware('auth:sanctum');

Route::get('cart', [ItemController::class,'cart'])->middleware('auth:sanctum');

Route::delete('cart/{item}', [ItemController::class,'deleteArticle'])->middleware('auth:sanctum');

Route::post('cart/{item}', [ItemController::class,'ajoutArticle'])->middleware('auth:sanctum');

Route::post('/register',[AuthController::class, 'registerUser']);
Route::post('/login',[AuthController::class, 'loginuser']);
Route::get('/logout',[AuthController::class, 'logout'])->middleware('auth:sanctum');

