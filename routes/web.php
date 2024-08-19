<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReceivingNotesController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Reports
Route::get('/product-report', [ReportController::class, 'productReport'])->name('product_report');
Route::get('/sales-report', [ReportController::class, 'salesReport'])->name('sales_report');
Route::get('/invoice', [ReportController::class, 'invoice'])->name('invoice.download');
Route::get('/receiving-notes/{id}', [ReportController::class, 'receivingNotes'])->name('receiving-notes');

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Admin routes
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'indexAdmin'])->name('admin.dashboard');
        Route::view('/report', 'admin.report.index')->name('admin.report');

        // Profile
        Route::get('/profile/{id}', [ProfileController::class, 'showProfile'])->name('profile.show');
        Route::put('/profile/{id}', [ProfileController::class, 'updateProfile'])->name('profile.update');

        // Categories
        Route::get('/category', [CategoryController::class, 'index'])->name('admin.category.index');
        Route::get('/category/add', [CategoryController::class, 'add'])->name('category.create');
        Route::get('/category/{category_id}', [CategoryController::class, 'show'])->name('admin.category.show');
        Route::post('/category/store', [CategoryController::class, 'store'])->name('admin.category.store');
        Route::get('/category/edit/{category_id}', [CategoryController::class, 'edit'])->name('admin.category.edit');
        Route::put('/category/update/{category_id}', [CategoryController::class, 'update'])->name('admin.category.update');
        Route::delete('/category/delete/{category_id}', [CategoryController::class, 'destroy'])->name('admin.category.delete');

        // Brands
        Route::get('/brand', [BrandController::class, 'index'])->name('admin.brand.index');
        Route::get('/brand/add', [BrandController::class, 'add'])->name('brand.create');
        Route::get('/brand/{brand_id}', [BrandController::class, 'show'])->name('admin.brand.show');
        Route::post('/brand/store', [BrandController::class, 'store'])->name('admin.brand.store');
        Route::get('/brand/edit/{brand_id}', [BrandController::class, 'edit'])->name('admin.brand.edit');
        Route::put('/brand/update/{brand_id}', [BrandController::class, 'update'])->name('admin.brand.update');
        Route::delete('/brand/delete/{brand_id}', [BrandController::class, 'destroy'])->name('admin.brand.delete');

        // Products
        Route::get('/product', [ProductController::class, 'index'])->name('admin.products.index');
        Route::get('/product/add', [ProductController::class, 'add'])->name('product.create');
        Route::get('/product/{product_id}', [ProductController::class, 'show'])->name('admin.products.show');
        Route::post('/product/store', [ProductController::class, 'store'])->name('admin.products.store');
        Route::get('/product/edit/{product_id}', [ProductController::class, 'edit'])->name('admin.products.edit');
        Route::put('/product/update/{product_id}', [ProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/product/delete/{product_id}', [ProductController::class, 'destroy'])->name('admin.products.delete');

        // Warehouses
        Route::get('/warehouse', [WarehouseController::class, 'index'])->name('admin.warehouse.index');
        Route::get('/warehouse/add', [WarehouseController::class, 'add'])->name('warehouse.create');
        Route::get('/warehouse/{warehouse_id}', [WarehouseController::class, 'show'])->name('admin.warehouse.show');
        Route::post('/warehouse/store', [WarehouseController::class, 'store'])->name('admin.warehouse.store');
        Route::get('/warehouse/edit/{warehouse_id}', [WarehouseController::class, 'edit'])->name('admin.warehouse.edit');
        Route::put('/warehouse/update/{warehouse_id}', [WarehouseController::class, 'update'])->name('admin.warehouse.update');
        Route::delete('/warehouse/delete/{warehouse_id}', [WarehouseController::class, 'destroy'])->name('admin.warehouse.delete');

        // Receiving Notes
        Route::get('/receivingNotes', [ReceivingNotesController::class, 'index'])->name('admin.receivingNotes.index');
        Route::get('/receivingNotes/add', [ReceivingNotesController::class, 'add'])->name('receivingNotes.create');
        Route::post('/receivingNotes/store', [ReceivingNotesController::class, 'store'])->name('receivingNotes.store');
        Route::delete('/receivingNotes/delete/{id}', [ReceivingNotesController::class, 'destroy'])->name('receivingNotes.destroy');

        // Transactions
        Route::get('/transaction', [TransactionController::class, 'indexAdmin'])->name('admin.transaction.index');

        // Users
        Route::get('/user', [UserController::class, 'index'])->name('admin.user.index');
        Route::get('/user/add', [UserController::class, 'add'])->name('user.create');
        Route::get('/user/{id}', [UserController::class, 'show'])->name('admin.user.show');
        Route::post('/user/store', [UserController::class, 'store'])->name('admin.user.store');
        Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('admin.user.edit');
        Route::put('/user/update/{id}', [UserController::class, 'update'])->name('admin.user.update');
        Route::delete('/user/delete/{id}', [UserController::class, 'destroy'])->name('admin.user.delete');

        // Currency
        Route::get('/currency', [CurrencyController::class, 'index'])->name('admin.currency.index');
        Route::post('/currency/update', [CurrencyController::class, 'update'])->name('currency.update');
    });

    // Kasir
    Route::get('/kasir/dashboard', [DashboardController::class, 'indexKasir'])->name('kasir.dashboard');
    Route::get('/transaction', [TransactionController::class, 'index'])->name('kasir.transaction.index');
    Route::get('/transaction/add', [TransactionController::class, 'add'])->name('transaction.create');
    Route::post('/transaction/store', [TransactionController::class, 'store'])->name('kasir.transaction.store');
});