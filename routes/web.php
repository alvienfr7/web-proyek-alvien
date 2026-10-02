<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublikasiController;
use App\Http\Controllers\AuthController;

Route::get('/', [PublikasiController::class, 'home'])->name('home');

Route::get('/publikasi', [PublikasiController::class, 'index'])->name('publikasi.index');

Route::get('/galeri-kegiatan', function () {
    $files   = glob(public_path('images/gambar*.*'));
    $gambars = array_map('basename', $files);

    return view('galeri_kegiatan', compact('gambars'));
})->name('galeri-kegiatan.index');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/publikasi', [PublikasiController::class, 'adminIndex'])->name('publikasi.index');
    Route::get('/publikasi/create', [PublikasiController::class, 'create'])->name('publikasi.create');
    Route::post('/publikasi', [PublikasiController::class, 'store'])->name('publikasi.store');
    Route::get('/publikasi/{id}/edit', [PublikasiController::class, 'edit'])->name('publikasi.edit');
    Route::put('/publikasi/{id}', [PublikasiController::class, 'update'])->name('publikasi.update');
    Route::delete('/publikasi/{id}', [PublikasiController::class, 'destroy'])->name('publikasi.destroy');
});