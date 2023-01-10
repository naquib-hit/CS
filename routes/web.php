<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProductUnitController,
    ProductController,
    CustomerController,
    InvoiceController,
    TransactionController
};

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

Route::middleware(['auth'])->group(function () {
    // Product
    Route::get('products/get', [ProductController::class, 'get'])->name('products.get');
    Route::resource('products', ProductController::class);
    // Product Unit
    Route::resource('product_units', ProductUnitController::class)->only(['index', 'create', 'store']);
    // Customers
    Route::delete('customers/truncate', [CustomerController::class, 'clean'])->name('customers.truncate');
    Route::get('customers/get', [CustomerController::class, 'get'])->name('customers.get');
    Route::resource('customers', CustomerController::class);
    // // Sales
    // Route::delete('sales/truncate', [SalesController::class, 'clean'])->name('sales.truncate');
    // Route::get('sales/get', [SalesController::class, 'get'])->name('sales.get');
    Route::get('invoices/products', [InvoiceController::class, 'getProducts'])->name('invoices.products');
    Route::get('invoices/customers', [InvoiceController::class, 'getCustomers'])->name('invoices.customers');
    Route::resource('invoices', InvoiceController::class);
    // Transactions
    Route::get('transactions/get', [TransactionController::class, 'get'])->name('transactions.get');
    Route::resource('transactions', TransactionController::class)->only(['index']);

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});
