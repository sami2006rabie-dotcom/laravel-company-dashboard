<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\DepartmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

Route::middleware('auth')->group(function () {
    Route::post('/auth/send-email-otp', [AuthController::class, 'sendEmailOtp']);
    Route::post('/auth/send-whatsapp-otp', [AuthController::class, 'sendWhatsappOtp']);
    Route::post('/auth/verify-otp', [AuthController::class, 'verifyOtp']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::get('/blog', [BlogPostController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogPostController::class, 'show'])->name('blog.show');

Route::middleware('auth')->group(function () {
    Route::get('/blog/create', [BlogPostController::class, 'create'])->name('blog.create');
    Route::post('/blog', [BlogPostController::class, 'store'])->name('blog.store');
    Route::get('/blog/{post}/edit', [BlogPostController::class, 'edit'])->name('blog.edit');
    Route::put('/blog/{post}', [BlogPostController::class, 'update'])->name('blog.update');
    Route::delete('/blog/{post}', [BlogPostController::class, 'destroy'])->name('blog.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('departments', DepartmentController::class);
});

require __DIR__.'/auth.php';