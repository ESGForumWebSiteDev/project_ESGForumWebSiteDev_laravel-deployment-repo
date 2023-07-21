<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\CheckController;
use App\Http\Controllers\CommitteeController;
use App\Http\Controllers\BusinessController;
use Illuminate\Support\Facades\Route;

/**
 * 로그인 관련 API
 */
Route::prefix('auth')->group(function () {
    Route::post('/login', [LoginController::class, 'login'])->name('api.login');
    Route::post('/register', [RegisterController::class, 'store'])->name('api.register');
    Route::post('/logout', [LogoutController::class, 'logout'])->middleware(['auth:sanctum'])->name('api.logout');
    Route::post('/check', [CheckController::class, 'isLoggedIn'])->middleware(['auth:sanctum'])->name('api.check');
});

/**
 * 위원회 관련 API
 */
Route::get('/committees', [CommitteeController::class, 'index'])->name('api.committees');   // TODO: 관리자 권한 필요

/**
 * 주요사업 관련 API
 */
Route::get('/business', [BusinessController::class, 'index'])->name('api.business');