<?php

use Illuminate\Support\Facades\Route;

$this->LinkNameSpace = "App\Http\Controllers\\";

// Auth
Route::get('/', [$this->LinkNameSpace.\Auth\AuthController::class, 'pageLogin'])->name('login');
Route::get('submit-logout', [$this->LinkNameSpace.\Auth\AuthController::class, 'submitLogout'])->middleware('auth')->name('logout');
// Page
Route::get('dashboard', [$this->LinkNameSpace.\Page\DashboardController::class, 'pageDashobard'])->middleware('auth')->name('dashboard');
// API
Route::group(['prefix' => 'api/v1'], function () {
    // Auth
    Route::group(['prefix' => 'auth'], function () {
        Route::post('submit-login', [$this->LinkNameSpace.\Auth\AuthController::class, 'submitLogin']);
        Route::post('submit-register', [$this->LinkNameSpace.\Auth\AuthController::class, 'submitRegister']);
    });
});