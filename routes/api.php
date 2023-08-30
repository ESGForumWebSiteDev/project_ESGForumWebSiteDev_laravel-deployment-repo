<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\RefreshTokenController;
use App\Http\Controllers\CommitteeController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HistoriesController;
use App\Http\Controllers\SeminarController;
use App\Http\Controllers\ReferenceController;
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
 * Seminars API
 */
Route::get(
    '/seminars',
    [SeminarController::class, 'index']
)->name('api.seminars');

Route::post(
    '/seminars',
    [SeminarController::class, 'store']
)->name('api.seminars');

Route::get(
    '/seminars/total',
    [SeminarController::class, 'total']
)->name('api.seminars');

Route::get(
    '/seminars/ongoing',
    [SeminarController::class, 'ongoingSeminars']
)->name('api.seminars');

Route::get(
    '/seminars/past',
    [SeminarController::class, 'pastSeminars']
)->name('api.seminars');

Route::get(
    '/seminars/search',
    [SeminarController::class, 'search']
)->name('api.seminars');

Route::get(
    '/seminars/{id}',
    [SeminarController::class, 'show']
)->name('api.seminars');

Route::put(
    '/seminars/{id}',
    [SeminarController::class, 'update']
)->name('api.seminars');

Route::delete(
    '/seminars/{id}',
    [SeminarController::class, 'destroy']
)->name('api.seminars');

/**
 * Reference API
 */
Route::get(
    '/reference',
    [ReferenceController::class, 'index']
)->name('api.reference');

Route::post(
    '/reference',
    [ReferenceController::class, 'store']
)->name('api.reference');

Route::get(
    '/reference/total',
    [ReferenceController::class, 'total']
)->name('api.reference');

Route::get(
    '/reference/search',
    [ReferenceController::class, 'search']
)->name('api.reference');

Route::get(
    '/reference/{id}',
    [ReferenceController::class, 'show']
)->name('api.reference');

Route::put(
    '/reference/{id}',
    [ReferenceController::class, 'update']
)->name('api.reference');

Route::delete(
    '/reference/{id}',
    [ReferenceController::class, 'destroy']
)->name('api.reference');

/**
 * AboutUs API
 */
Route::get(
    '/aboutus/objective',
    [AboutUsController::class, 'showObjective']
)->name('api.aboutus.objective');

Route::get(
    '/aboutus/vision',
    [AboutUsController::class, 'showVision']
)->name('api.aboutus.vision');

Route::get(
    '/aboutus/histories',
    [HistoriesController::class, 'index']
)->name('api.aboutus.histories');

Route::get(
    '/aboutus/greetings',
    [AboutUsController::class, 'showGreetings']
)->name('api.aboutus.greetings');

Route::get(
    '/aboutus/rules',
    [AboutUsController::class, 'showRules']
)->name('api.aboutus.rules');

Route::get(
    '/aboutus/ci_logo',
    [AboutUsController::class, 'showCiLogo']
)->name('api.aboutus.ci_logo');

Route::post(
    '/aboutus',
    [AboutUsController::class, 'store']
)->name('api.aboutus');


// File Upload API
Route::post(
    '/upload',
    [FileController::class, 'store']
)->name('api.upload');

Route::delete(
    '/upload',
    [FileController::class, 'destory']
)->name('api.upload');


/**
 * 관리자 권한 요함
 */
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    /**
     * 위원회 관련 API
     */
    Route::post('/committees', [CommitteeController::class, 'store'])->name('api.committees');
    Route::put('/committees/{committee}', [CommitteeController::class, 'update'])->name('api.committees');
    Route::delete('/committees/{committee}', [CommitteeController::class, 'destroy'])->name('api.committees');

    /**
     * 위원회 멤버 관련 API
     */
    Route::post('/committees/{committee}/members', [CommitteeController::class, 'storeMember'])->name('api.committees.members');
    Route::put('/committees/{committee}/members/{member}', [CommitteeController::class, 'updateMember'])->name('api.committees.members');
    Route::delete('/committees/{committee}/members/{member}', [CommitteeController::class, 'destroyMember'])->name('api.committees.members');

    /**
     * 주요사업 관련 API
     */
    Route::post('/business', [BusinessController::class, 'store'])->name('api.business');
    Route::put('/business/{business}', [BusinessController::class, 'update'])->name('api.business');
    Route::delete('/business/{business}', [BusinessController::class, 'destroy'])->name('api.business');
});