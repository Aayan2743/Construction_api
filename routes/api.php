<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\EducationController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SpecializationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ApplyJobCotroller;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CandidateEducationController;
use App\Http\Controllers\CandidateProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactSettingController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerCareController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IndustryController;
use App\Http\Controllers\LandingBannerController;
use App\Http\Controllers\menuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OtpAuthController;
use App\Http\Controllers\PaymentGatewayController;
use App\Http\Controllers\phonepaycontroller;
use App\Http\Controllers\posController;
use App\Http\Controllers\ProductBarcodeController;
use App\Http\Controllers\ProductBulkImportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\ProductSeoMetaController;
use App\Http\Controllers\ProductTaxAffinityController;
use App\Http\Controllers\ProductVariantController;
use App\Http\Controllers\ProductVariationController;
use App\Http\Controllers\ProductVariationValueController;
use App\Http\Controllers\RigJobCategoryController;
use App\Http\Controllers\RigJobController;
use App\Http\Controllers\RozarpayPaymentController;
use App\Http\Controllers\SavedJobController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\ShiprocketController;
use App\Http\Controllers\StaffAttendanceController;
use App\Http\Controllers\StaffUserController;
use App\Http\Controllers\WhatsAppController;
use App\Http\Controllers\WhatsappSettingController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;




Route::prefix('auth')->group(function () {

    // ================= AUTH =================



    Route::post('admin-register', [AuthController::class, 'register'])->name('admin.register');;
    Route::post('admin-login', [AuthController::class, 'login'])->name('admin.login');
    Route::post('manager-login', [AuthController::class, 'manager_loign'])->name('manager.login');




    // ================= PASSWORD / OTP =================
    Route::post('forgot-password', [AuthController::class, 'sendOtp']);
    Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);

    Route::post('organization/forgot-password', [AuthController::class, 'OrgsendOtp']);


});


Route::prefix('admin')->middleware(['api', 'jwt.auth'])->group(function () {

    Route::prefix('users')->group(function () {
        Route::post('/create', [UserController::class, 'store'])->name('users.create');
        Route::get('/', [UserController::class, 'index'])->name('users.list');
        Route::get('/list-all-users', [UserController::class, 'get_all'])->name('users.list_all');
    });


    Route::prefix('projects')->group(function () {
            Route::post('/add', [ProjectController::class, 'store']);
            Route::get('/list', [ProjectController::class, 'index']);
            Route::get('/show/{id}', [ProjectController::class, 'show']);
            Route::post('/update/{id}', [ProjectController::class, 'update']);
            Route::delete('/delete/{id}', [ProjectController::class, 'destroy']);
    });

    Route::prefix('vendors')->group(function () {
            Route::post('/add', [VendorController::class, 'store']);
            Route::get('/list', [VendorController::class, 'index']);
            Route::get('/show/{id}', [VendorController::class, 'show']);
            Route::post('/update/{id}', [VendorController::class, 'update']);
            Route::delete('/delete/{id}', [VendorController::class, 'destroy']);
    });

});
