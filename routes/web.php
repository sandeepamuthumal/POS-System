<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\purchaseController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
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

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login_process', [LoginController::class, 'login_process'])->name('login_process');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/', [LoginController::class, 'index']);



Route::middleware(['isLoggedIn'])->group(function () {

    Route::get('/user/dashboard', [LoginController::class, 'UserDashboard'])->name('user_dashboard');
    Route::get('/admin/dashboard', [LoginController::class, 'AdminDashboard'])->name('admin_dashboard');

    Route::controller(UserController::class)->group(function () {
        Route::get('/users-active', 'ActiveUsers')->name('active_users');
        Route::get('/users-deactive', 'DeactiveUsers')->name('deactive_users');
        Route::post('/users/load/active', 'showactive');
        Route::post('/users/load/deactive', 'showdeactive');
        Route::post('/users/store', 'store');
        Route::post('/users/delete/{id}', 'delete')->name('delete_users');
        Route::post('/users/change/password', 'ChangePassword');
        Route::get('/users/edit', 'edit');
        Route::post('/users/update', 'update');
    });


    Route::controller(CustomerController::class)->group(function () {
        Route::get('/customers', 'AllCustomers')->name('all_customers');
        Route::get('/customers/all', 'LoadAllCustomers');
        Route::post('/customer/store', 'CustomerStore');
        Route::get('/customer/edit', 'edit');
        Route::post('/customer/update', 'update');
        Route::post('/customer/delete/{id}', 'delete')->name('delete_customer');
        Route::get('/customers-deactive', 'DeactiveCustomers')->name('deactive_customer');
        Route::post('/customers/load/deactive', 'showdeactive');
    });

    Route::controller(SupplierController::class)->group(function () {
        Route::get('/suppliers', 'AllSuppliers')->name('all_suppliers');
        Route::get('/suppliers/all', 'LoadAllSuppliers');
        Route::post('/supplier/store', 'SupplierStore');
        Route::get('/supplier/edit', 'edit');
        Route::post('/supplier/update', 'update');
        Route::post('/supplier/delete/{id}', 'delete')->name('delete_supplier');
    });

    Route::controller(ProductController::class)->group(function () {
        Route::get('/products', 'products')->name('products');
        Route::get('/create/product', 'createProduct')->name('create_product');
        Route::post('/category/store', 'storeCategory');
        Route::get('/category/load', 'loadCategory');
        Route::post('/product/store', 'storeProduct')->name('store_product');
        Route::post('/product/delete/{id}', 'deleteProduct')->name('delete_product');
        Route::get('/product/edit', 'editProduct');
        Route::get('/product/view/{id}', 'viewProduct');
        Route::get('/product/download/{id}', 'downloadQrcode');
        Route::post('/product/update', 'updateProduct');
    });

    Route::controller(purchaseController::class)->group(function () {
        Route::get('/purchases', 'purchases')->name('purchases');
        Route::post('/add/purchase/item', 'addPurchaseItem');
        Route::get('/load/purchase/items', 'loadPurchaseItems');
        Route::get('/delete/purchase/item', 'deletePurchaseItem');
        Route::get('/load/purchase/code', 'loadPurchaseCode');
        Route::get('/purchase/edit', 'editPurchase');
        Route::post('/purchase/delete/{id}', 'delete')->name('delete_purchase');;
        Route::post('/purchase/store', 'storePurchases');
        Route::post('/purchase/load/active', 'loadPurchaseActive');
    });

    Route::controller(SalesController::class)->group(function () {
        Route::get('/sales', 'sales')->name('sales');
        Route::get('/sales/receipt/view/{id}', 'salesView');
        Route::get('/sales/pos', 'pos')->name('pos');
        Route::get('/show/product/details', 'showProduct');
        Route::post('/sale/item/store', 'storeSaleProduct');
        Route::post('/sale/submit', 'submitSale');
    });
});

Route::get('clear_cache', function () {
    \Artisan::call('config:cache');
    \Artisan::call('view:clear');
    \Artisan::call('route:clear');
});
