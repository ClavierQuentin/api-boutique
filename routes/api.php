<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Mailjet\LaravelMailjet\Facades\Mailjet;

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
Route::apiResource('item', App\Http\Controllers\ItemController::class);
Route::post('/register',[AuthController::class, 'registerUser']);
Route::post('/login',[AuthController::class, 'loginuser']);
Route::get('/logout',[AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('send-mail', function () {

    $details = [

        'title' => 'Mail from ItSolutionStuff.com',

        'body' => 'This is for testing email using smtp'

    ];

    // Mail::to('a.raguenes@gmail.com')->send(new \App\Mail\MyTestMail($details));
    Mail::to('clavier.quentin@gmail.com')->send(new \App\Mail\MyTestMail($details));
});
