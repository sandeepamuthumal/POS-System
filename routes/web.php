<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\LoginController;
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

    Route::controller(ItemsController::class)->group(function () {
        Route::post('/items/load/active', 'showactiveitem');
        Route::get('/items', 'viewItem')->name('items');
        Route::post('/branch/store', 'storebranch');
        Route::post('/categorie/store', 'storecategorie');
        Route::post('/item/store', 'storeitem');
        Route::post('/items/delete/{id}', 'delete')->name('delete_item');
        Route::get('/item/edit', 'edit');
        Route::post('/item/update', 'update');
    });
});

Route::get('clear_cache', function () {
    \Artisan::call('config:cache');
    \Artisan::call('view:clear');
    \Artisan::call('route:clear');
});
