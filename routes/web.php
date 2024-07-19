<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/profile', [UserController::class, 'show'])->name('profile.show');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/download-sales-report', [ReportController::class, 'downloadSalesReport'])->name('download.sales.report');
Route::get('/download-income-report', [ReportController::class, 'downloadIncomeReport'])->name('download.income.report');
Route::get('/invoice', [ReportController::class, 'invoice'])->name('invoice.download');

Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'indexAdmin'])->name('admin.dashboard');
    Route::view('/admin/report', 'admin.report.index')->name('admin.report');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile', [UserController::class, 'updateProfile'])->name('profile.update');

    Route::prefix('admin')->group(function () {
        Route::get('/category', [CategoryController::class, 'index'])->name('admin.category.index');
        Route::post('/category/store', [CategoryController::class, 'store'])->name('admin.category.store');
        Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('admin.category.edit');
        Route::put('/category/update/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
        Route::delete('/category/delete/{id}', [CategoryController::class, 'destroy'])->name('admin.category.delete');
        Route::get('/brand', [BrandController::class, 'index'])->name('admin.brand.index');
        Route::post('/brand/store', [BrandController::class, 'store'])->name('admin.brand.store');
        Route::get('/brand/edit/{id}', [BrandController::class, 'edit'])->name('admin.brand.edit');
        Route::put('/brand/update/{id}', [BrandController::class, 'update'])->name('admin.brand.update');
        Route::delete('/brand/delete/{id}', [BrandController::class, 'destroy'])->name('admin.brand.delete');
        Route::get('/product', [ProductController::class, 'index'])->name('admin.products.index');
        Route::post('/product/store', [ProductController::class, 'store'])->name('admin.products.store');
        Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('admin.products.edit');
        Route::put('/product/update/{id}', [ProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/product/delete/{id}', [ProductController::class, 'destroy'])->name('admin.products.delete');
        Route::get('/transaction', [TransactionController::class, 'indexAdmin'])->name('admin.transaction.index');
        Route::get('/user', [UserController::class, 'index'])->name('admin.user.index');
        Route::post('/user/store', [UserController::class, 'store'])->name('admin.user.store');
        Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('admin.user.edit');
        Route::put('/user/update/{id}', [UserController::class, 'update'])->name('admin.user.update');
        Route::delete('/user/delete/{id}', [UserController::class, 'destroy'])->name('admin.user.delete');
        
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/kasir/dashboard', [DashboardController::class, 'indexKasir'])->name('kasir.dashboard');
    Route::get('/kasir/transaction', [TransactionController::class, 'index'])->name('kasir.transaction.index');
    Route::get('/kasir/transaction/add', [TransactionController::class, 'add'])->name('kasir.transaction.add');
    Route::post('/kasir/transaction/store', [TransactionController::class, 'store'])->name('kasir.transaction.store');
});

