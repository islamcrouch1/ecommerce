<?php

use App\Http\Controllers\Affiliate\AffiliateProductsController;
use App\Http\Controllers\Affiliate\CartController;
use App\Http\Controllers\Affiliate\FavoriteController;
use App\Http\Controllers\Affiliate\OrdersController;
use App\Http\Controllers\Affiliate\ReviewsController;
use App\Http\Controllers\Affiliate\ShippingRatesController;
use App\Http\Controllers\Affiliate\StoreController;
use App\Http\Controllers\Dashboard\HomeController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'affiliate', 'middleware' => ['role:affiliate']], function () {

    // affiliate products routes
    Route::get('products', [AffiliateProductsController::class, 'index'])->name('affiliate.products.index')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('products/{product}', [AffiliateProductsController::class, 'showProduct'])->name('affiliate.products.product')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('products/category/{category}', [AffiliateProductsController::class, 'showCatProducts'])->name('affiliate.products.category')->middleware('auth', 'checkverified', 'checkstatus');

    // favorite routes
    Route::get('favorite', [FavoriteController::class, 'index'])->name('favorite')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('favorite/{product}', [FavoriteController::class, 'add'])->name('favorite.add')->middleware('auth', 'checkverified', 'checkstatus');

    // affiliate cart routes
    Route::get('cart', [CartController::class, 'index'])->name('cart')->middleware('auth', 'checkverified', 'checkstatus');
    Route::post('cart/store', [CartController::class, 'store'])->name('cart.store')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('cart/destroy/{product}/{stock}', [CartController::class, 'destroy'])->name('cart.destroy')->middleware('auth', 'checkverified', 'checkstatus');
    Route::post('cart/change', [CartController::class, 'changeQuantity'])->name('cart.change')->middleware('auth', 'checkverified', 'checkstatus');

    // add new order affiliate
    Route::post('order/store', [OrdersController::class, 'store'])->name('affiliate.orders.store')->middleware('auth', 'checkverified', 'checkstatus');

    // affiliate orders routes
    Route::get('orders', [OrdersController::class, 'index'])->name('orders.affiliate.index')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('orders/cancel/{order}', [OrdersController::class, 'cancelOrder'])->name('orders.affiliate.cancel')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('orders/show/{order}', [OrdersController::class, 'show'])->name('orders.affiliate.show')->middleware('auth', 'checkverified', 'checkstatus');
    Route::post('orders/refund/{order}', [OrdersController::class, 'storeRefund'])->name('orders.affiliate.refund')->middleware('auth', 'checkverified', 'checkstatus');

    // shipping rates routes
    Route::get('shipping-rates', [ShippingRatesController::class, 'index'])->name('shipping_rates.affiliate')->middleware('auth', 'checkverified', 'checkstatus');

    // reviews routes
    Route::post('reviews/{product}', [ReviewsController::class, 'store'])->name('reviews.affiliate.index')->middleware('auth', 'checkverified', 'checkstatus');

    // store routes
    Route::post('mystore/{product}', [StoreController::class, 'store'])->name('mystore.store')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('mystore', [StoreController::class, 'show'])->name('mystore.show')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('mystore/delete/{product}', [StoreController::class, 'destroy'])->name('mystore.destroy')->middleware('auth', 'checkverified', 'checkstatus');
});
