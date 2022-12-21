<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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

Auth::routes([
    'registration' => false
]);

Route::get('products/get', [ProductController::class, 'get']);
Route::resource('products', ProductController::class);

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
