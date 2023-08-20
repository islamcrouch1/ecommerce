<?php

use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'store'], function () {

    // store routes
    Route::get('/{user}', [StoreController::class, 'show'])->name('store.show');
    Route::get('/{user}/product/{product}', [StoreController::class, 'product'])->name('store.product');
    Route::post('/order-complete/{user}/product/{product}', [StoreController::class, 'store'])->name('store.store');
    Route::get('/order/success', [StoreController::class, 'success'])->name('store.success');
});
