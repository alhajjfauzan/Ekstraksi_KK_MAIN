<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController; 
use App\Http\Controllers\KartuKeluargaController; 
use App\Http\Controllers\KeluargaController;
Route::get('/', function () {
    return view('landing');
})->name('landing');
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/api/upload', [KeluargaController::class, 'storeUpload'])->name('api.upload');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/tambah', [KartuKeluargaController::class, 'create'])->name('tambah');
Route::post('/tambah', [KartuKeluargaController::class, 'store'])->name('tambah.store'); 
Route::get('/keluarga/upload', [KeluargaController::class, 'uploadStart'])->name('keluarga.upload');
Route::get('/keluarga/upload/preview', function () {
    return view('upload');
})->name('keluarga.preview');
// Route::get('/keluarga/{id}/edit', function ($id) {
//     return view('keluarga.edit', ['id' => $id]);
// })->name('keluarga.edit');
Route::get('/kartu-keluarga/{no_kk}/edit', [KartuKeluargaController::class, 'edit'])->name('keluarga.detail');
Route::put('/kartu-keluarga/{no_kk}', [KartuKeluargaController::class, 'update'])->name('kartu-keluarga.update');;
Route::get('/keluarga/{no_kk}', [KartuKeluargaController::class, 'show'])->name('keluarga.detail');
Route::resource('kartu-keluarga', KartuKeluargaController::class);
Route::post('/cek-duplikat', [CekDuplikatController::class, 'cek']);
Route::post('/cek-duplikat', function (\Illuminate\Http\Request $request) {
    $nik = $request->nik;
    $no_kk = $request->no_kk;

    return response()->json([
        'nik_exists' => $nik 
            ? \App\Models\AnggotaKeluarga::where('nik', $nik)->exists()
            : false,

        'no_kk_exists' => $no_kk
            ? \App\Models\KartuKeluarga::where('no_kk', $no_kk)->exists()
            : false,
    ]);
})
;