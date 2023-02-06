<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProductUnitController,
    ProductController,
    CustomerController,
    HomeController,
    InvoiceController,
    RecurringInvoiceController,
    ReportController,
    TaxController,
    TransactionController,
    UserController
};
use App\Models\User;

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
    // Taxes
    Route::delete('taxes/truncate', [TaxController::class, 'truncate'])->name('taxes.truncate');
    Route::get('taxes/get', [TaxController::class, 'get'])->name('taxes.get');
    Route::resource('taxes', TaxController::class);
    // // Sales
    // Route::delete('sales/truncate', [SalesController::class, 'clean'])->name('sales.truncate');
    // Route::get('sales/get', [SalesController::class, 'get'])->name('sales.get');
    Route::get('invoices/products', [InvoiceController::class, 'getProducts'])->name('invoices.products');
    Route::get('invoices/customers', [InvoiceController::class, 'getCustomers'])->name('invoices.customers');
    Route::get('invoices/taxes', [InvoiceController::class, 'getTaxes'])->name('invoices.taxes');
    Route::get('invoices/get', [InvoiceController::class, 'get'])->name('invoices.get');
    Route::get('invoices/mail/{id}', [InvoiceController::class, 'mail'])->name('invoices.mail');
    Route::resource('invoices', InvoiceController::class);
    // Reccuring INvoices
    Route::get('reccuringInvoices/get', [RecurringInvoiceController::class, 'get'])->name('reccuringInvoices.get');
    Route::resource('reccuringInvoices', RecurringInvoiceController::class);
    // Transactions
    Route::get('transactions/get', [TransactionController::class, 'get'])->name('transactions.get');
    Route::resource('transactions', TransactionController::class)->only(['index']);
    // Report
    Route::resource('reports', ReportController::class);
    //Users
    Route::get('users/get', [UserController::class, 'get'])->name('users.get');
    Route::resource('users', UserController::class);

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('logout/', [HomeController::class, 'logout'])->name('logout');
});