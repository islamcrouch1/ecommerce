
<?php

use App\Http\Controllers\Dashboard\ImportController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'import', 'middleware' => ['role:superadministrator|administrator']], function () {

    Route::post('/products', [ImportController::class, 'import'])->name('products.import')->middleware('auth', 'checkverified', 'checkstatus');
});
