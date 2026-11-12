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
        // Route::resource('products', ProductController::class);
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

    Route::get('masters/category/index', [MastersController::class, 'categoryIndex'])->name('masters.category');
    Route::get('masters/category/create', [MastersController::class, 'createCategory'])->name('masters.create.category');
    Route::post('masters/category/store', [MastersController::class, 'storeCategory'])->name('masters.store.category');
    Route::get('masters/category/edit/{slug}', [MastersController::class, 'editCategory'])->name('masters.editcategory');
    Route::put('masters/category/update/{slug}', [MastersController::class, 'editCategory'])->name('masters.update');
    
    // size routes
    Route::get('masters/size/index', [MastersController::class, 'sizeIndex'])->name('masters.size');
    Route::get('masters/size/create', [MastersController::class, 'createSize'])->name('masters.create.size');
    Route::post('masters/size/store', [MastersController::class, 'storeSize'])->name('masters.store.size');
    Route::get('masters/size/edit/{slug}', [MastersController::class, 'editSize'])->name('masters.editsize');
    Route::put('masters/size/update/{slug}', [MastersController::class, 'editSize'])->name('masters.size.update');
    //color routes

    Route::get('masters/color/index', [MastersController::class, 'colorIndex'])->name('masters.color');
    Route::get('masters/color/create', [MastersController::class, 'createColor'])->name('masters.create.color');
    Route::post('masters/color/store', [MastersController::class, 'storeColor'])->name('masters.store.color');
    Route::get('masters/color/edit/{slug}', [MastersController::class, 'editColor'])->name('masters.editcolor');
    Route::put('masters/color/update/{slug}', [MastersController::class, 'editColor'])->name('masters.color.update');
    
    //Brand routes
     Route::get('masters/brand/index', [MastersController::class, 'brandIndex'])->name('masters.brand');
    Route::get('masters/brand/create', [MastersController::class, 'createBrand'])->name('masters.create.brand');
    Route::post('masters/brand/store', [MastersController::class, 'storeBrand'])->name('masters.store.brand');
    Route::get('masters/brand/edit/{slug}', [MastersController::class, 'editBrand'])->name('masters.editbrand');
    Route::put('masters/brand/update/{slug}', [MastersController::class, 'editBrand'])->name('masters.brand.update');
    
    //Brand Sizes routes
    Route::get('masters/brand/sizes/{slug}', [MastersController::class, 'brandSizes'])->name('masters.brand.sizes');
    Route::get('masters/brand/create-size/{slug}', [MastersController::class, 'createBrandSize'])->name('masters.brand.createSize');
    Route::post('masters/brand/store-size/{slug}', [MastersController::class, 'storeBrandSizeCsvExport'])->name('masters.store.brand.size');
    Route::post('masters/brand/upload-brand-sizes/{slug}', [MastersController::class, 'uploadBrandSizes'])->name('masters.upload.brand.sizes');
    


    //Products
    Route::get('products/index', [ProductController::class, 'index'])->name('masters.products.index');
    Route::get('products/create', [ProductController::class, 'create'])->name('masters.products.create');
    Route::post('products/store', [ProductController::class, 'storeProduct'])->name('masters.products.store');
    Route::put('products/basicUpdate/{slug}', [ProductController::class, 'basicUpdate'])->name('masters.products.basicUpdate');
    Route::get('products/{randomid}/edit', [ProductController::class, 'editProduct'])->name('masters.products.edit');
    Route::get('products/{randomid}/view', [ProductController::class, 'viewProduct'])->name('masters.products.view');
    Route::put('products/variations/{randomid}', [ProductController::class, 'actionVariation'])->name('masters.products.variations');
    
    Route::post('products/{randomid}/color-media', [ProductController::class, 'uploadColorMedia'])
    ->name('masters.products.color-media.upload');

    Route::delete('products/{randomid}/color-media/{id}', [ProductController::class, 'deleteColorMedia'])
    ->whereNumber('id')
    ->name('masters.products.color-media.delete');
    Route::put('products/{randomid}/color-media/sort', [ProductController::class, 'sortColorMedia'])
    ->name('masters.products.color-media.sort');

    Route::post('products/{randomid}/variations/excel', [ProductController::class, 'downloadAllVariationExcel'])
    ->name('masters.products.variations.excel');
    Route::post('products/{randomid}/variations/upload-excel', [ProductController::class, 'uploadVariationExcel'])
    ->name('masters.products.variations.upload-excel');

    Route::delete('products/{randomid}', [ProductController::class, 'destroy'])->name('masters.products.destroy');







    
    //delete route for both category and size
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