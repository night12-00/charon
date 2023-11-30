<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\UserInvitationController;
use App\Http\Controllers\API\ProfileController;

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

Route::prefix('api')
  ->middleware('api')
  ->group(static function (): void {
    Route::post('me', [AuthController::class, 'login'])->name('auth.login');
    Route::delete('me', [AuthController::class, 'logout']);

    Route::get('ping', static fn() => null);

    // User and user profile routes
    Route::apiResource('user', UserController::class);
    Route::get('me', [ProfileController::class, 'show']);
    Route::put('me', [ProfileController::class, 'update']);
  });
