<?php

use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\PermissionController;
use Illuminate\Support\Facades\Route;
// routes/web.php
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Shared\ManagerController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Shared\{DashboardController, MastersController, ProductController, OrderController};

Route::view('/','welcome')->name('/');
        Route::get('/reset-password/{token}', function ($token) {
            return view('auth.reset-password', ['token' => $token]);
        })->name('password.reset');
         
        Route::post('/new-password', [LoginController::class, 'updatePassword'])
         ->name('login.new.password');

Route::prefix('admin')->name('admin.')->group(function () {

    // admin's public pages
    Route::middleware(['guest'])->group(function () {

        Route::get('/', [LoginController::class, 'showAdminLogin'])->name('login');
        Route::post('login', [LoginController::class, 'adminLogin'])->name('login.submit');
        Route::view('/forgot-password','auth.forgot-password')->name('login.forgot-password');
        Route::post('/generate-reset-password', [LoginController::class, 'generateResetPassword'])->name('login.generateResetPassword');

        });

    // Admin + Manager
    Route::middleware(['auth', 'role:admin|manager'])->group(function () {
        Route::get('logout', [LogoutController::class, 'logout'])->name('logout');
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('products', ProductController::class);
        Route::resource('orders', OrderController::class);
        Route::resource('managers', ManagerController::class);

        // Route::get('products', [ProductController::class, 'index'])
        //     ->middleware('can:category.view')
        //     ->name('products.index');

        // Admin only
        Route::middleware('role:admin')->group(function () {
            
        });

        
    
     Route::resource('modules', ModuleController::class)->only(['index', 'create', 'store','destroy']);
    // Route::get('modules/create', [ModuleController::class, 'create'])->name('modules.create');
    // Route::post('modules', [ModuleController::class, 'store'])->name('modules.store');

    //
    Route::get('permissions/{role:name}', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::put('permissions/{role:name}', [PermissionController::class, 'update'])->name('permissions.update');

    //ecommerce 

    Route::get('masters/category', [MastersController::class, 'categoryIndex'])->name('masters.category');
    Route::get('masters/category/create', [MastersController::class, 'createCategory'])->name('masters.create.category');
    Route::post('masters/category/store', [MastersController::class, 'storeCategory'])->name('masters.store.category');
    Route::get('masters/category/edit/{slug}', [MastersController::class, 'editCategory'])->name('masters.editcategory');
    Route::put('masters/category/update/{slug}', [MastersController::class, 'editCategory'])->name('masters.update');
    Route::get('masters/delete/{mode}/{slug}', [MastersController::class, 'masterDelete'])->name('masters.delete');

    //manager
    Route::get('manager/index', [ManagerController::class, 'index'])->name('manager.index');
    Route::get('manager/create', [ManagerController::class, 'create'])->name('manager.create');
    Route::post('manager/store', [ManagerController::class, 'store'])->name('manager.store');

    // Keep GET for viewing the edit form
    Route::get('manager/edit/{slug}', [ManagerController::class, 'edit'])->name('manager.edit');

    // FIX: Change to 'update' method and rename to 'manager.update'
    Route::put('manager/update/{slug}', [ManagerController::class, 'edit'])->name('manager.update');
    Route::put('manager/password/{slug}', [ManagerController::class, 'updatePassword'])->name('manager.updatePassword');

    Route::get('manager/delete/{slug}', [ManagerController::class, 'destroy'])->name('manager.delete');

    });
});