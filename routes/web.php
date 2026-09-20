<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

        Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('dashboard');
        Route::get('/jurusan', function () { return view('admin.jurusan.index'); })->name('jurusan');
        Route::get('/sarana', function () { return view('admin.sarana.index'); })->name('sarana');
        Route::get('/pengajuan', function () { return view('admin.pengajuan.index'); })->name('pengajuan');
        Route::get('/pengembalian', function () { return view('admin.pengembalian.index'); })->name('pengembalian');
        Route::get('/jadwal', function () { return view('admin.jadwal.index'); })->name('jadwal');

    });

/*
|--------------------------------------------------------------------------
| Peminjam
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:peminjam'])->prefix('peminjam')->name('peminjam.')->group(function () {

        Route::get('/dashboard', function () { return view('peminjam.dashboard'); })->name('dashboard');
        Route::get('/sarana', function () { return view('peminjam.sarana.index'); })->name('sarana');
        Route::get('/peminjaman', function () { return view('peminjam.peminjaman.index'); })->name('peminjaman');
        Route::get('/riwayat', function () { return view('peminjam.riwayat.index'); })->name('riwayat');

    });
