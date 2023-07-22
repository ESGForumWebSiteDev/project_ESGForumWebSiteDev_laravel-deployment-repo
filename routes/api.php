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
Route::post('/committees', [CommitteeController::class, 'store'])->name('api.committees'); // TODO: 관리자 권한 필요
Route::get('/committees', [CommitteeController::class, 'index'])->name('api.committees');   // TODO: 관리자 권한 필요
Route::put('/committees/{committee}', [CommitteeController::class, 'update'])->name('api.committees'); // TODO: 관리자 권한 필요
Route::delete('/committees/{committee}', [CommitteeController::class, 'destroy'])->name('api.committees'); // TODO: 관리자 권한 필요

/**
 * 위원회 멤버 관련 API
 */
Route::post('/committees/{committee}/members', [CommitteeController::class, 'storeMember'])->name('api.committees.members'); // TODO: 관리자 권한 필요
Route::put('/committees/{committee}/members/{member}', [CommitteeController::class, 'updateMember'])->name('api.committees.members'); // TODO: 관리자 권한 필요
Route::delete('/committees/{committee}/members/{member}', [CommitteeController::class, 'destroyMember'])->name('api.committees.members'); // TODO: 관리자 권한 필요

/**
 * 주요사업 관련 API
 */
Route::post('/business', [BusinessController::class, 'store'])->name('api.business'); // TODO: 관리자 권한 필요
Route::get('/business', [BusinessController::class, 'index'])->name('api.business'); // TODO: 관리자 권한 필요
Route::put('/business/{business}', [BusinessController::class, 'update'])->name('api.business'); // TODO: 관리자 권한 필요
Route::delete('/business/{business}', [BusinessController::class, 'destroy'])->name('api.business'); // TODO: 관리자 권한 필요