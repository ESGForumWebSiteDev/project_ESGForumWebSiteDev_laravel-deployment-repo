<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\RefreshTokenController;
use App\Http\Controllers\CommitteeController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CommitteeMemberController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/**
 * 로그인 관련 API
 */
Route::prefix('auth')->group(function () {
    Route::post('/login', [LoginController::class, 'login'])->name('api.login');
    Route::post('/register', [RegisterController::class, 'store'])->name('api.register');
    Route::post('/logout', [LogoutController::class, 'logout'])->middleware(['auth:sanctum'])->name('api.logout');
    Route::post('/refresh_token', [RefreshTokenController::class, 'refreshToken'])->name('api.refresh_token');
});

/**
 * 위원회 조회 API
 */
Route::get('/committees', [CommitteeController::class, 'index'])->name('api.committees');

/**
 * 주요사업 조회 API
 */
Route::get('/business', [BusinessController::class, 'index'])->name('api.business');

/**
 * 관리자 권한 요함
 */
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    /**
     * 위원회 관련 API
     */
    Route::get('/committees', [CommitteeController::class, 'index'])->name('api.committees');
    Route::post('/committees', [CommitteeController::class, 'store'])->name('api.committees');
    Route::get('/committee/{id}', [CommitteeController::class, 'find'])->name('api.committee');
    Route::put('/committees/{id}', [CommitteeController::class, 'update'])->name('api.committees');
    Route::delete('/committee/{id}', [CommitteeController::class, 'destroy'])->name('api.committees');

    /**
     * 위원회 멤버 관련 API
     */
    Route::get('/committees/{id}/members', [CommitteeMemberController::class, 'index'])->name('api.committees');
    Route::delete('/committees/{c_id}/members/{m_id}', [CommitteeMemberController::class, 'destroy'])->name('api.committees.members');
    Route::post('/committees/{id}/members', [CommitteeMemberController::class, 'store'])->name('api.committees.members');
    Route::put('/committees/{c_id}/members/{m_id}', [CommitteeMemberController::class, 'update'])->name('api.committees.members');

    /**
     * 주요사업 관련 API
     */
    Route::post('/business', [BusinessController::class, 'store'])->name('api.business');
    Route::put('/business/{business}', [BusinessController::class, 'update'])->name('api.business');
    Route::delete('/business/{business}', [BusinessController::class, 'destroy'])->name('api.business');

    /**
     * 사용자 관련 API
     */
    Route::get('/users/subscribers', [UserController::class, 'subscribers'])->name('api.users');
    Route::get('/users', [UserController::class, 'index'])->name('api.users');
    Route::put('/users/approval', [UserController::class, 'approval'])->name('api.users');

    /**
     * 회원 관련 API
     */
    Route::get('/members', [MemberController::class, 'index'])->name('api.members');
    Route::put('/members', [MemberController::class, 'update'])->name('api.members');
    Route::delete('/members/{id}', [MemberController::class, 'destroy'])->name('api.members');
});