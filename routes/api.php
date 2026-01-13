<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\KartuKeluargaApiController;
use App\Http\Controllers\Api\AnggotaKeluargaApiController;
use App\Http\Controllers\Api\DataKelahiranApiController;
use App\Http\Controllers\Api\DataDokumenApiController;
use App\Http\Controllers\Api\DataStatusApiController;
use App\Http\Controllers\Api\AgamaApiController;
use App\Http\Controllers\Api\PendidikanApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route untuk mendapatkan user yang sedang login (authenticated)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*
|--------------------------------------------------------------------------
| Kartu Keluarga API Routes
|--------------------------------------------------------------------------
*/
Route::prefix('kartu-keluarga')->group(function () {
    Route::get('/', [KartuKeluargaApiController::class, 'index']);
    Route::post('/', [KartuKeluargaApiController::class, 'store']);
    Route::get('/search', [KartuKeluargaApiController::class, 'search']);
    Route::get('/{no_kk}', [KartuKeluargaApiController::class, 'show']);
    Route::put('/{no_kk}', [KartuKeluargaApiController::class, 'update']);
    Route::delete('/{no_kk}', [KartuKeluargaApiController::class, 'destroy']);
});

/*
|--------------------------------------------------------------------------
| Anggota Keluarga API Routes
|--------------------------------------------------------------------------
*/
Route::prefix('anggota-keluarga')->group(function () {
    Route::get('/', [AnggotaKeluargaApiController::class, 'index']);
    Route::post('/', [AnggotaKeluargaApiController::class, 'store']);
    Route::get('/search', [AnggotaKeluargaApiController::class, 'search']);
    Route::get('/kartu-keluarga/{no_kk}', [AnggotaKeluargaApiController::class, 'getByKartuKeluarga']);
    Route::get('/{nik}', [AnggotaKeluargaApiController::class, 'show']);
    Route::put('/{nik}', [AnggotaKeluargaApiController::class, 'update']);
    Route::delete('/{nik}', [AnggotaKeluargaApiController::class, 'destroy']);
});

/*
|--------------------------------------------------------------------------
| Data Kelahiran API Routes
|--------------------------------------------------------------------------
*/
Route::prefix('data-kelahiran')->group(function () {
    Route::get('/', [DataKelahiranApiController::class, 'index']);
    Route::post('/', [DataKelahiranApiController::class, 'store']);
    Route::get('/{nik_fk}', [DataKelahiranApiController::class, 'show']);
    Route::put('/{nik_fk}', [DataKelahiranApiController::class, 'update']);
    Route::delete('/{nik_fk}', [DataKelahiranApiController::class, 'destroy']);
});

/*
|--------------------------------------------------------------------------
| Data Dokumen API Routes
|--------------------------------------------------------------------------
*/
Route::prefix('data-dokumen')->group(function () {
    Route::get('/', [DataDokumenApiController::class, 'index']);
    Route::post('/', [DataDokumenApiController::class, 'store']);
    Route::get('/{nik_fk}', [DataDokumenApiController::class, 'show']);
    Route::put('/{nik_fk}', [DataDokumenApiController::class, 'update']);
    Route::delete('/{nik_fk}', [DataDokumenApiController::class, 'destroy']);
});

/*
|--------------------------------------------------------------------------
| Data Status API Routes
|--------------------------------------------------------------------------
*/
Route::prefix('data-status')->group(function () {
    Route::get('/', [DataStatusApiController::class, 'index']);
    Route::post('/', [DataStatusApiController::class, 'store']);
    Route::get('/{nik_fk}', [DataStatusApiController::class, 'show']);
    Route::put('/{nik_fk}', [DataStatusApiController::class, 'update']);
    Route::delete('/{nik_fk}', [DataStatusApiController::class, 'destroy']);
});

/*
|--------------------------------------------------------------------------
| Agama API Routes
|--------------------------------------------------------------------------
*/
Route::prefix('agama')->group(function () {
    Route::get('/', [AgamaApiController::class, 'index']);
    Route::post('/', [AgamaApiController::class, 'store']);
    Route::get('/{nik_fk}', [AgamaApiController::class, 'show']);
    Route::put('/{nik_fk}', [AgamaApiController::class, 'update']);
    Route::delete('/{nik_fk}', [AgamaApiController::class, 'destroy']);
});

/*
|--------------------------------------------------------------------------
| Pendidikan API Routes
|--------------------------------------------------------------------------
*/
Route::prefix('pendidikan')->group(function () {
    Route::get('/', [PendidikanApiController::class, 'index']);
    Route::post('/', [PendidikanApiController::class, 'store']);
    Route::get('/{nik_fk}', [PendidikanApiController::class, 'show']);
    Route::put('/{nik_fk}', [PendidikanApiController::class, 'update']);
    Route::delete('/{nik_fk}', [PendidikanApiController::class, 'destroy']);
});

/*
|--------------------------------------------------------------------------
| Health Check Route
|--------------------------------------------------------------------------
*/
Route::get('/health', function () {
    return response()->json([
        'status' => 'OK',
        'message' => 'API is running',
        'timestamp' => now()->toDateTimeString()
    ]);
});
