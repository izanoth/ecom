<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ShippingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/********************
       PAGES
********************/
Route::get('/', [ViewController::class, 'welcome']);
Route::get('/home', [ViewController::class, 'welcome'])->name('home');
Route::get('/product', [ViewController::class, 'product'])->name('product');
Route::get('/search', [ViewController::class, 'search'])->name('search');
Route::get('/cart', [ViewController::class, 'cart'])->name('cart');

/********************
   CUSTOMER SESSION
********************/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [UserController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [UserController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout');
    
    //Route::get('/checkout/process', [CheckoutController::class, 'process'])->name('process');
    //Route::get('/checkout/process', [CheckoutController::class, 'process'])->name('checkshipaddr');

    /************/
    /*** APIs ***/
    /************/






    Route::get('/checkout/shipaddr-create', [ShippingController::class, 'create'])->name('checkout.shipaddr.create');
    Route::post('/checkout/shipaddr-create', [ShippingController::class, 'store'])->name('checkout.shipaddr.store');
    Route::get('checkout/shipaddr-delete', [ShippingController::class, 'remove'])->name('checkout.shipaddr.delete');


    //Route::get('/checkout/payment', [CheckoutController::class, 'payChoice'])->name('checkout.payment.choice');


    /*    Route::get('/checkout/payment/choice', [CheckoutController::class, 'choice'])->name('checkout.payment.choice');

        Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');*/
});

/********************
      DINAMICS
********************/
/** CART */
Route::get('/cart/append', [CartController::class, 'append'])->name('cart.append');
Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'async_update'])->name('cart.update');

/********************
    ADMIN SESSION
********************/
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login');

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/panel', [AdminController::class, 'panel'])->name('admin.panel');
    Route::get('/admin/new', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/admin/new', [AdminController::class, 'store'])->name('admin.store');
    Route::get('/admin/hasher', [AdminController::class, 'hasher'])->name('admin.hasher');
    Route::post('/admin/hasher', [AdminController::class, 'hasher'])->name('admin.hasher.gen');

    /*
     *   Crud Products
     */
    Route::get('/admin/product', [ProductController::class, 'index'])
        ->name('admin.product.index');

    Route::get('/admin/product/create', [ProductController::class, 'create'])
        ->name('admin.product.create');
    Route::get('/admin/product/store', [ProductController::class, 'insertBelongs'])
        ->name('admin.belongs.store');
    Route::post('/admin/product/store', [ProductController::class, 'store'])
        ->name('admin.product.store');

    Route::get('/admin/product/{id}', [ProductController::class, 'show'])
        ->name('admin.product.show');
    Route::get('/admin/product/{id}/edit', [ProductController::class, 'edit'])
        ->name('admin.product.edit');

    Route::put('/admin/product/{id}', [ProductController::class, 'update'])
        ->name('admin.product.update');

    Route::delete('/admin/product/{id}', [ProductController::class, 'destroy'])
        ->name('admin.product.destroy');

    Route::get('/telescope', '\Laravel\Telescope\Http\Controllers\HomeController@index')->name('admin.telescope');
});







Route::middleware('session')->group(function () {


});

Route::get('/admin/logout', [AdminController::class, 'logout'])
    ->name('admin.logout');



require __DIR__ . '/auth.php';
