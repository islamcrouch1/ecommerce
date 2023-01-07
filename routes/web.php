<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;

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

Route::redirect('/', '/ecommerce');
//front route


Route::get('/', [FrontController::class, 'index'])->name('front.index');
Route::get('/fqs', [FrontController::class, 'fqs'])->name('front.fqs');
Route::get('/about-us', [FrontController::class, 'about'])->name('front.about');
Route::get('/terms-conditions', [FrontController::class, 'terms'])->name('front.terms');


Route::get('/setlocale', function () {
    setLocaleBySession();
    return redirect()->back();
})->name('setlocale');


require __DIR__ . '/auth.php';
require __DIR__ . '/dashboard.php';
require __DIR__ . '/affiliate.php';
require __DIR__ . '/vendor.php';
require __DIR__ . '/verification.php';
require __DIR__ . '/user.php';
require __DIR__ . '/store.php';
require __DIR__ . '/ecommerce.php';
