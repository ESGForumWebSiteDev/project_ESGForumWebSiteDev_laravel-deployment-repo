<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Requests\LoginRequest;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [LoginController::class, 'login'])->name('api.login');
Route::post('/register', [RegisterController::class, 'register'])->name('api.register');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
