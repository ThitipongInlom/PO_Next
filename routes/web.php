<?php

use Illuminate\Support\Facades\Route;

$this->LinkNameSpace = "App\Http\Controllers\\";

// Auth
Route::get('/', [$this->LinkNameSpace.\Auth\AuthController::class, 'pageLogin'])->name('login');
Route::get('submit-logout', [$this->LinkNameSpace.\Auth\AuthController::class, 'submitLogout'])->middleware('auth')->name('logout');
// Page
Route::get('dashboard', [$this->LinkNameSpace.\Page\DashboardController::class, 'pageDashobard'])->middleware('auth')->name('dashboard');
// Admin
Route::get('staff_list', [$this->LinkNameSpace.\Admin\StaffListController::class, 'pageStaffList'])->middleware('auth')->name('staff_list');
// API
Route::group(['prefix' => 'api/v1'], function () {
    // Auth
    Route::group(['prefix' => 'auth'], function () {
        Route::post('submit-login', [$this->LinkNameSpace.\Auth\AuthController::class, 'submitLogin']);
        Route::post('submit-register', [$this->LinkNameSpace.\Auth\AuthController::class, 'submitRegister']);
    });
    // Staff List
    Route::group(['prefix' => 'staff_list'], function () {
        Route::post('get-user_data_id', [$this->LinkNameSpace.\Admin\StaffListController::class, 'getUserDataId'])->middleware('auth');
        Route::post('submit-edit', [$this->LinkNameSpace.\Admin\StaffListController::class, 'submitEdit'])->middleware('auth');
        Route::post('submit-change_password', [$this->LinkNameSpace.\Admin\StaffListController::class, 'submitChangePassword'])->middleware('auth');
        Route::post('submit-delete', [$this->LinkNameSpace.\Admin\StaffListController::class, 'submitDelete'])->middleware('auth');
    });
    // General
    Route::group(['prefix' => 'general'], function () {
        Route::post('submit-online_user', [$this->LinkNameSpace.\Setting\FunctionController::class, 'submitOnlineUser'])->middleware('auth');
    });
    // DataTable
    Route::group(['prefix' => 'datatable'], function () {
        Route::post('get-datatable', [$this->LinkNameSpace.\Setting\TableController::class, 'getSwithDataTable'])->middleware('auth');
    });
});