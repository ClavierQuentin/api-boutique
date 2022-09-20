<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/login', function () {
    // Only authenticated users may access this route...
})->middleware('auth.basic');



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::resource('item', App\Http\Controllers\ItemController::class);

Route::resource('order', App\Http\Controllers\OrderController::class);

Route::post('/enregistrement', [\App\Http\Controllers\UtilisateurController::class, 'register']);



