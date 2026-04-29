<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\EquipmentEntryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LabourReportController;
use App\Http\Controllers\mobile\LabourController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {

    // ================= AUTH =================

    Route::post('admin-register', [AuthController::class, 'register'])->name('admin.register');
    Route::post('admin-login', [AuthController::class, 'login'])->name('admin.login');

    Route::post('manager-login', [AuthController::class, 'managerLogin'])->name('manager.login');

    // ================= PASSWORD / OTP =================
    Route::post('forgot-password', [AuthController::class, 'sendOtp']);
    Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);

    Route::post('organization/forgot-password', [AuthController::class, 'OrgsendOtp']);

});

Route::prefix('admin')->middleware(['api', 'jwt.auth'])->group(function () {

    Route::prefix('users')->group(function () {
        Route::post('/create', [UserController::class, 'store'])->name('users.create');
        Route::post('/update/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('users.delete');
        Route::get('/profile', [UserController::class, 'getProfile'])->name('users.profile');
        Route::post('/update-profile', [UserController::class, 'updateProfile'])->name('users.update_profile');
        Route::get('/', [UserController::class, 'index'])->name('users.list');
        Route::get('/list-all-users', [UserController::class, 'get_all'])->name('users.list_all');
    });

    Route::prefix('projects')->group(function () {
        Route::post('/add', [ProjectController::class, 'store']);
        Route::get('/list', [ProjectController::class, 'index']);
        Route::get('/show/{id}', [ProjectController::class, 'show']);
        Route::post('/update/{id}', [ProjectController::class, 'update']);
        Route::delete('/delete/{id}', [ProjectController::class, 'destroy']);
        Route::get('/projects-by-manager/{id}', [ProjectController::class, 'getProjectsByManager']);

    });

    Route::prefix('vendors')->group(function () {
        Route::post('/add', [VendorController::class, 'store']);
        Route::get('/list', [VendorController::class, 'index']);
        Route::get('/list-all', [VendorController::class, 'list_all']);
        Route::get('/show/{id}', [VendorController::class, 'show']);
        Route::post('/update/{id}', [VendorController::class, 'update']);
        Route::delete('/delete/{id}', [VendorController::class, 'destroy']);
    });

    Route::prefix('accounts')->group(function () {
        Route::post('/allocate', [AccountController::class, 'storeAllocation']);
        Route::get('/get-allocations', [AccountController::class, 'index']);
        Route::delete('/delete-allocation/{id}', [AccountController::class, 'destroy']);
        Route::post('/update-allocations/{id}', [AccountController::class, 'update']);
    });

});

Route::prefix('manager')->middleware(['api', 'jwt.auth'])->group(function () {

    Route::get('/my-projects', [ProjectController::class, 'myProjects']);
    Route::get('/my-project/{id}', [ProjectController::class, 'myProject'])->name('my-project-by-id');

    Route::prefix('labours')->group(function () {

        Route::get('/list', [LabourController::class, 'index']);
        Route::post('/add', [LabourController::class, 'store']);
        Route::get('/show/{id}', [LabourController::class, 'show']);
        Route::post('/update/{id}', [LabourController::class, 'update']);
        Route::delete('/delete/{id}', [LabourController::class, 'destroy']);
    });

    Route::prefix('labours')->group(function () {
        Route::post('/attendance/mark', [AttendanceController::class, 'markAttendance']);
        Route::get('/attendance/today', [AttendanceController::class, 'todayAttendance']);

        Route::post('/reports', [LabourReportController::class, 'store']);
        Route::get('/reports', [LabourReportController::class, 'index']);
        Route::post('/update-reports/{id}', [LabourReportController::class, 'update']);

    });

    Route::get('/items', [ItemController::class, 'index']);
    Route::get('/vendors-by-type', [VendorController::class, 'vendorsByType']);
    Route::get('get-machinery', [ItemController::class, 'get_machinery']);
    Route::get('get-material', [ItemController::class, 'get_material']);
    Route::post('/add-items', [ItemController::class, 'store']);
    Route::post('/update-items/{id}', [ItemController::class, 'update']);
    Route::delete('/items/{id}', [ItemController::class, 'destroy']);

    Route::prefix('equipment-entries')->group(function () {
        Route::get('/', [EquipmentEntryController::class, 'index']);
        Route::post('/add', [EquipmentEntryController::class, 'store']);
        Route::get('/show/{id}', [EquipmentEntryController::class, 'show']);
        Route::post('/update/{id}', [EquipmentEntryController::class, 'update']);
        Route::delete('/delete/{id}', [EquipmentEntryController::class, 'destroy']);

    });

});
