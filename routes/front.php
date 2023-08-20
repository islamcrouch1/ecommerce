<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;


//front route
Route::get('/front', [FrontController::class, 'index'])->name('front.index');
Route::get('/front/fqs', [FrontController::class, 'fqs'])->name('front.fqs');
Route::get('/front/about-us', [FrontController::class, 'about'])->name('front.about');
Route::get('/front/strategy', [FrontController::class, 'strategy'])->name('front.strategy');
Route::get('/front/terms-conditions', [FrontController::class, 'terms'])->name('front.terms');
Route::get('/front/contact', [FrontController::class, 'contact'])->name('front.contact');


Route::get('/front/steel', [FrontController::class, 'steel'])->name('front.steel');
Route::get('/front/real', [FrontController::class, 'real'])->name('front.real');
Route::get('/front/currency', [FrontController::class, 'currency'])->name('front.currency');
Route::get('/front/educational', [FrontController::class, 'educational'])->name('front.educational');


Route::get('/front/photos', [FrontController::class, 'photos'])->name('front.photos');
Route::get('/front/videos', [FrontController::class, 'videos'])->name('front.videos');


Route::get('/front/careers', [FrontController::class, 'careers'])->name('front.careers');
