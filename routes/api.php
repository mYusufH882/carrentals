<?php

use App\Http\Controllers\Api\MobilController;
use App\Http\Controllers\Api\PeminjamanController;
use App\Http\Controllers\Api\PengembalianController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/register', RegisterController::class)->name('register');
Route::post('/login', LoginController::class)->name('login');

Route::middleware('auth:api')->group(function() {
    Route::group(['prefix' => 'mobil'], function() {
        Route::get('/', [MobilController::class, 'index'])->name('mobil');
    });
    
    Route::get('/peminjaman', [PeminjamanController::class, 'listPinjamMobil']);
    Route::get('/pengembalian', [PengembalianController::class, 'listPengembalianMobil']);
    
    Route::middleware('role:rental')->group(function() {
        Route::group(['prefix' => 'mobil'], function() {
            Route::post('/create', [MobilController::class, 'store'])->name('mobil-create');
            Route::put('/edit/{id}', [MobilController::class, 'edit'])->name('mobil-edit');
            Route::delete('/delete/{id}', [MobilController::class, 'delete'])->name('mobil-delete');
        });
    });


    Route::middleware('role:customer')->group(function() {
        Route::post('/peminjaman-mobil', [PeminjamanController::class, 'peminjamanStore'])->name('peminjaman');
        Route::post('/pengembalian-mobil', [PengembalianController::class, 'pengembalianStore'])->name('pengembalian');
    });

    Route::post('/logout', LogoutController::class)->name('logout');
});