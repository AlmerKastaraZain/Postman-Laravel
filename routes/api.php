<?php

use App\Http\Controllers\ApiAdminController;
use App\Http\Controllers\ApiDataAbsensiController;
use App\Http\Controllers\ApiDataGajiKaryawan;
use App\Http\Controllers\ApiDataJabatan;
use App\Http\Controllers\ApiDataKaryawan;
use App\Http\Controllers\ApiSetPotonganGaji;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->name('api.admin.')->group(function () {
    Route::post('register', [ApiAdminController::class, 'register'])->name('register');
    Route::post('login', [ApiAdminController::class, 'login'])->name('login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [ApiAdminController::class, 'logout'])->name('logout');
        Route::get('show', [ApiAdminController::class, 'index'])->name('index');
        Route::get('{id}/show', [ApiAdminController::class, 'show'])->name('show');
        Route::post('store', [ApiAdminController::class, 'store'])->name('store'); // Consider if this is needed or if register is enough
        Route::put('{id}/update', [ApiAdminController::class, 'update'])->name('update');
        Route::delete('{id}/destroy', [ApiAdminController::class, 'destroy'])->name('destroy');
    });
});

Route::group(['prefix' => 'data-jabatan'], function () {
    Route::get('show', [ApiDataJabatan::class, 'index'])->name('api.data-jabatan.index');
    Route::get('{id}/show', [ApiDataJabatan::class, 'show'])->name('api.data-jabatan.show');
    Route::post('store', [ApiDataJabatan::class, 'store'])->name('api.data-jabatan.store');
    Route::put('{id}/update', [ApiDataJabatan::class, 'update'])->name('api.data-jabatan.update');
    Route::delete('{id}/destroy', [ApiDataJabatan::class, 'destroy'])->name('api.data-jabatan.destroy');
})->middleware('auth:sanctum');

Route::group(['prefix' => 'gaji-karyawan'], function () {
    Route::get('show', [ApiDataGajiKaryawan::class, 'index'])->name('api.gaji-karyawan.index');
    Route::get('{id}/show', [ApiDataGajiKaryawan::class, 'show'])->name('api.gaji-karyawan.show');
    Route::post('store', [ApiDataGajiKaryawan::class, 'store'])->name('api.gaji-karyawan.store');
    Route::put('{id}/update', [ApiDataGajiKaryawan::class, 'update'])->name('api.gaji-karyawan.update');
    Route::delete('{id}/destroy', [ApiDataGajiKaryawan::class, 'destroy'])->name('api.gaji-karyawan.destroy');
})->middleware('auth:sanctum');

Route::group(['prefix' => 'data-absensi'], function () {
    Route::get('show', [ApiDataAbsensiController::class, 'index'])->name('api.data-absensi.index');
    Route::get('{id}/show', [ApiDataAbsensiController::class, 'show'])->name('api.data-absensi.show');
    Route::post('store', [ApiDataAbsensiController::class, 'store'])->name('api.data-absensi.store');
    Route::put('{id}/update', [ApiDataAbsensiController::class, 'update'])->name('api.data-absensi.update');
    Route::delete('{id}/destroy', [ApiDataAbsensiController::class, 'destroy'])->name('api.data-absensi.destroy');
})->middleware('auth:sanctum');

Route::group(['prefix' => 'data-karyawan'], function () {
    Route::get('show',[ApiDataKaryawan::class, 'index'] )->name('api.data-karyawan.index');
    Route::get('{id}/show', [ApiDataKaryawan::class, 'show'])->name('api.data-karyawan.show');
    Route::post('store', [ApiDataKaryawan::class, 'store'])->name('api.data-karyawan.store');
    Route::put('{id}/update', [ApiDataKaryawan::class, 'update'])->name('api.data-karyawan.update');
    Route::delete('{id}/destroy', [ApiDataKaryawan::class, 'destroy'])->name('api.data-karyawan.destroy');
})->middleware('auth:sanctum');

Route::group(['prefix' => 'set-potongan-gaji'], function () {
    Route::get('show', [ApiSetPotonganGaji::class, 'index'])->name('api.set-potongan-gaji.index');
    Route::get('{id}/show', [ApiSetPotonganGaji::class, 'show'])->name('api.set-potongan-gaji.show');
    Route::post('store', [ApiSetPotonganGaji::class, 'store'])->name('api.set-potongan-gaji.store');
    Route::put('{id}/update', [ApiSetPotonganGaji::class, 'update'])->name('api.set-potongan-gaji.update');
    Route::delete('{id}/destroy', [ApiSetPotonganGaji::class, 'destroy'])->name('api.set-potongan-gaji.destroy');
})->middleware('auth:sanctum');