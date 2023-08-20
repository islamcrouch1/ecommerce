<?php

use App\Http\Controllers\Vendor\ExportController;
use App\Http\Controllers\Vendor\OrdersController;
use App\Http\Controllers\Vendor\VendorProductsController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'vendor', 'middleware' => ['role:vendor']], function () {

    // vendor orders routes indexOrdersVendors
    Route::get('/orders', [OrdersController::class, 'index'])->name('vendor.orders.index')->middleware('auth', 'checkverified', 'checkstatus');

    // vendor products routes
    Route::resource('/vendor-products', VendorProductsController::class)->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/products/vendor/export', [ExportController::class, 'productsExport'])->name('vendor-products.export')->middleware('auth', 'checkverified', 'checkstatus');
    Route::post('/products/import/', [ExportController::class, 'import'])->name('vendor-products.import')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/products/stock/{product}', [VendorProductsController::class, 'stockCreate'])->name('vendor-products.stock.create')->middleware('auth', 'checkverified', 'checkstatus');
    Route::post('/products/stock-store/{product}', [VendorProductsController::class, 'stockStore'])->name('vendor-products.stock.store')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/products/color/{product}', [VendorProductsController::class, 'colorCreate'])->name('vendor-products.color.create')->middleware('auth', 'checkverified', 'checkstatus');
    Route::post('/products/color-store/{product}', [VendorProductsController::class, 'colorStore'])->name('vendor-products.color.store')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/stock/color-remove/{stock}', [VendorProductsController::class, 'colorDestroy'])->name('vendor-products.color.destroy')->middleware('auth', 'checkverified', 'checkstatus');
});
