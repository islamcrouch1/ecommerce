
<?php

use App\Http\Controllers\Dashboard\ExportController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'export', 'middleware' => ['role:superadministrator|administrator']], function () {
    // export and import routes
    Route::get('/orders',  [ExportController::class, 'ordersExport'])->name('orders.export')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/withdrawals', [ExportController::class, 'withdrawalsExport'])->name('withdrawals.export')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/products', [ExportController::class, 'productsExport'])->name('products.export')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/users', [ExportController::class, 'usersExport'])->name('users.export')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/accounts', [ExportController::class, 'accountsExport'])->name('accounts.export')->middleware('auth', 'checkverified', 'checkstatus');
});
