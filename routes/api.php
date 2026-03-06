<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\auth\SocialiteController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskPriorityController;
use App\Http\Controllers\UserPreferenceController;

// Auth (public)
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login',    [AuthController::class, 'login']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('reset-password',  [AuthController::class, 'resetPassword']);

    // Socialite
    Route::get('google/redirect',      [SocialiteController::class, 'redirectToGoogle']);
    Route::get('google/callback',      [SocialiteController::class, 'handleGoogleCallback']);
    Route::post('google/mobile',       [SocialiteController::class, 'handleGoogleMobile']);
    Route::get('apple/redirect',       [SocialiteController::class, 'redirectToApple']);
    Route::post('apple/callback',      [SocialiteController::class, 'handleAppleCallback']);
    Route::post('apple/mobile',        [SocialiteController::class, 'handleAppleMobile']);
});

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::prefix('auth')->group(function () {
        Route::get('me',          [AuthController::class, 'me']);
        Route::post('logout',     [AuthController::class, 'logout']);
        Route::post('logout-all', [AuthController::class, 'logoutAll']);
    });

    // User Preferences
    Route::get('preferences', [UserPreferenceController::class, 'show']);
    Route::put('preferences', [UserPreferenceController::class, 'update']);
    Route::get('admin/preferences', [UserPreferenceController::class, 'index']); // Protected by policy

    // Tasks & Priorities
    Route::apiResource('tasks',           TaskController::class);
    Route::apiResource('task-priorities', TaskPriorityController::class);
});
