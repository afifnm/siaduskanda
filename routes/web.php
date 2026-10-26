<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\PetugasDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - SIADU SMKN 2 Karanganyar
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/riwayat', [PengaduanController::class, 'history'])->name('pengaduan.history');
Route::get('/riwayat-pengaduan', [PengaduanController::class, 'history']);
Route::get('/buat-pengaduan', [PengaduanController::class, 'create'])->name('pengaduan.create');
Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');
Route::get('/lacak-pengaduan', [PengaduanController::class, 'track'])->name('pengaduan.track');
Route::get('/lacak', [PengaduanController::class, 'track']);
Route::post('/pengaduan/{pengaduan}/feedback', [PengaduanController::class, 'submitFeedback'])->name('pengaduan.feedback');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Compatibility Aliases for HTML Template Filenames
Route::redirect('/index.html', '/');
Route::redirect('/buat-pengaduan.html', '/buat-pengaduan');
Route::redirect('/lacak-pengaduan.html', '/lacak-pengaduan');
Route::redirect('/riwayat-pengaduan.html', '/riwayat');
Route::redirect('/login.html', '/login');
Route::redirect('/admin-dashboard.html', '/admin');
Route::redirect('/petugas-dashboard.html', '/admin');
Route::redirect('/petugas', '/admin');

// Admin Panel Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::post('/pengaduan/{pengaduan}/assign', [AdminDashboardController::class, 'assign'])->name('assign');
    Route::post('/pengaduan/{pengaduan}/close', [AdminDashboardController::class, 'close'])->name('close');
});

// Technical Actions Routes (Admin-only)
Route::middleware(['auth', 'role:admin'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/', fn () => redirect()->route('admin.dashboard'))->name('dashboard');
    Route::post('/pengaduan/{pengaduan}/start', [PetugasDashboardController::class, 'start'])->name('start');
    Route::post('/pengaduan/{pengaduan}/resolve', [PetugasDashboardController::class, 'resolve'])->name('resolve');
});
