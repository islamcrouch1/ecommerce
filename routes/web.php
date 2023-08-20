<?php

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


Route::get('/ali', [FrontController::class, 'aliexpress'])->name('front.aliexpress');


if (!file_exists(storage_path('installed'))) {
    Route::redirect('/', '/install');
}


// Route::get('/sendemail', function () {
//     sendEmail();
//     return 'done';
// })->name('send.eamil');



Route::get('/', function () {
    return redirect()->route('ecommerce.home');
})->name('base.url');


Route::get('/setlocale', function () {
    setLocaleBySession();
    return redirect()->back()->withInput();
})->name('setlocale');

require __DIR__ . '/auth.php';
require __DIR__ . '/affiliate.php';
require __DIR__ . '/vendor.php';
require __DIR__ . '/verification.php';
require __DIR__ . '/user.php';
require __DIR__ . '/store.php';
require __DIR__ . '/ecommerce.php';
require __DIR__ . '/dashboard.php';
require __DIR__ . '/front.php';
require __DIR__ . '/export.php';
require __DIR__ . '/import.php';
