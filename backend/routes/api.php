<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TodoController;

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

// Auth routes
Route::post('/login', [AuthController::class, 'getAccessToken'])->name('api.auth.login');
Route::post('/logout', [AuthController::class, 'deleteAccessToken'])->name('api.auth.logout');
Route::post('/recover-password', [AuthController::class, 'recoverPassword'])->name('api.auth.recover');

// Create user
Route::post('/users', [UserController::class, 'create'])->name('api.user.create');

Route::middleware('auth:sanctum')->resource('todos', TodoController::class);
