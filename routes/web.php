<?php

use Illuminate\Support\Facades\Auth;
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
    return redirect('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('item', App\Http\Controllers\ItemController::class);
Route::post('item/verified', [App\Http\Controllers\ItemController::class, 'verified'])->name('item.verified');




/*Route::group(['prefix' => 'admin', 'middleware' => ['role:admin']], function() {
    Route::get('/', [App\Http\Controllers\AdminController::class, 'index']);
});*/

/*
Route::group(['middleware' => ['role:user']], function() {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});*/