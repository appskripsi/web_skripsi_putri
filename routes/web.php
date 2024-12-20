<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookRatingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RepositoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', DashboardController::class)->name('dashboard');

Route::middleware('guest:student')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::controller(AuthController::class)->group(function () {
            Route::get('login', 'login')->name('login');
            Route::get('register', 'register')->name('register');
            Route::post('login', 'onLogin');
            Route::post('register', 'onRegister');
        });
    });
});

Route::resource('book', BookController::class)->only(['index', 'show']);
Route::resource('repository', RepositoryController::class)->only(['index', 'show']);

Route::middleware('student')->group(function () {
    Route::resource('feedback', FeedbackController::class)->only(['index', 'store']);
    Route::resource('profile', ProfileController::class)->only(['index', 'update']);
    Route::resource('loan', LoanController::class)->only(['index', 'create', 'store']);
    Route::resource('rating', BookRatingController::class)->only(['store']);

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});
