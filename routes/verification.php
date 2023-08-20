<?php

use App\Http\Controllers\Dashboard\PhoneVerificationController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['role:superadministrator|administrator|affiliate|vendor']], function () {

    // verification routes
    Route::get('/phone/verify', [PhoneVerificationController::class, 'show'])->name('phoneverification.notice')->middleware('auth', 'checkstatus');
    Route::post('/phone/verify', [PhoneVerificationController::class, 'verify'])->name('phoneverification.verify')->middleware('auth', 'checkstatus');
    Route::get('/resend-code', [PhoneVerificationController::class, 'resend'])->name('resend-code')->middleware('auth', 'checkstatus');
});
