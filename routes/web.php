<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController; // Tambahkan ini
use App\Http\Controllers\KartuKeluargaController; // Tambahkan ini jika belum

// Halaman Landing Page
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Auth Routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard - Update untuk menggunakan controller
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Halaman Tambah Manual - Update untuk menggunakan controller
Route::get('/tambah', [KartuKeluargaController::class, 'create'])->name('tambah');
Route::post('/tambah', [KartuKeluargaController::class, 'store'])->name('tambah.store'); // Tambahkan untuk POST

// Halaman Tambah Via Upload (Awal)
Route::get('/keluarga/upload', function () {
    return view('keluarga.upload-start');
})->name('keluarga.upload');

// Halaman Upload Akhir (Preview)
Route::get('/keluarga/upload/preview', function () {
    return view('upload');
})->name('keluarga.preview');

// Halaman Edit (Manual 2) - Mengambil ID
Route::get('/keluarga/{id}/edit', function ($id) {
    return view('keluarga.edit', ['id' => $id]);
})->name('keluarga.edit');

// Tambahkan route untuk detail keluarga (baru, sesuai saran sebelumnya)
Route::get('/keluarga/{no_kk}', [KartuKeluargaController::class, 'show'])->name('keluarga.detail');