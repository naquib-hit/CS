<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{ ProductController, CustomerController };

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

// Product
Route::get('products/get', [ProductController::class, 'get'])->name('products.get');
Route::resource('products', ProductController::class);
// Customers
Route::delete('customers/truncate', [CustomerController::class, 'clean'])->name('customers.truncate');
Route::get('customers/get', [CustomerController::class, 'get'])->name('customers.get');
Route::resource('customers', CustomerController::class);

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
