<?php
use App\Http\Controllers\Admin\JadwalPenggunaanController;
use App\Http\Controllers\Admin\JurusanController;
use App\Http\Controllers\Admin\PengajuanController as AdminPengajuanController;
use App\Http\Controllers\Admin\PengembalianController as AdminPengembalianController;
use App\Http\Controllers\Admin\SaranaController as AdminSaranaController;

use App\Http\Controllers\Peminjam\SaranaController as PeminjamSaranaController;
use App\Http\Controllers\Peminjam\PengajuanController as PeminjamPengajuanController;
use App\Http\Controllers\Peminjam\PengembalianController as PeminjamPengembalianController;
use App\Http\Controllers\Peminjam\RiwayatController;

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

        Route::get('/jurusan', [JurusanController::class, 'index'])->name('jurusan.index');
        Route::get('/jurusan/create', [JurusanController::class, 'create'])->name('jurusan.create');
        Route::post('/jurusan', [JurusanController::class, 'store'])->name('jurusan.store');
        Route::get('/jurusan/{jurusan}/edit', [JurusanController::class, 'edit'])->name('jurusan.edit');
        Route::put('/jurusan/{jurusan}', [JurusanController::class, 'update'])->name('jurusan.update');
        Route::delete('/jurusan/{jurusan}', [JurusanController::class, 'destroy'])->name('jurusan.destroy');

        Route::get('/sarana', [AdminSaranaController::class, 'index'])->name('sarana.index');
        Route::get('/sarana/create', [AdminSaranaController::class, 'create'])->name('sarana.create');
        Route::post('/sarana', [AdminSaranaController::class, 'store'])->name('sarana.store');
        Route::get('/sarana/{sarana}/edit', [AdminSaranaController::class, 'edit'])->name('sarana.edit');
        Route::put('/sarana/{sarana}', [AdminSaranaController::class, 'update'])->name('sarana.update');
        Route::delete('/sarana/{sarana}', [AdminSaranaController::class, 'destroy'])->name('sarana.destroy');
        Route::get('/sarana/export', [AdminSaranaController::class, 'export'])->name('sarana.export');

        Route::get('/pengajuan', [AdminPengajuanController::class, 'index'])->name('pengajuan.index');
        Route::get('/pengajuan/{peminjaman}', [AdminPengajuanController::class, 'show'])->name('pengajuan.show');
        Route::patch('/pengajuan/{peminjaman}/approve', [AdminPengajuanController::class, 'approve'])->name('pengajuan.approve');
        Route::patch('/pengajuan/{peminjaman}/reject', [AdminPengajuanController::class, 'reject'])->name('pengajuan.reject');

        Route::get('/pengembalian', [AdminPengembalianController::class, 'index']) ->name('pengembalian.index');
        Route::get('/pengembalian/{pengembalian}', [AdminPengembalianController::class, 'show'])->name('pengembalian.show');
        Route::patch('/pengembalian/{pengembalian}/process', [AdminPengembalianController::class, 'process'])->name('pengembalian.process');
       
        Route::get('/jadwal', [JadwalPenggunaanController::class, 'index'])->name('jadwal.index');
        Route::get('/jadwal/{jadwalPenggunaan}', [JadwalPenggunaanController::class, 'show'])->name('jadwal.show');

    });

/*
|--------------------------------------------------------------------------
| Peminjam
|--------------------------------------------------------------------------
*/
    Route::middleware(['auth', 'role:peminjam'])
    ->prefix('peminjam')
    ->name('peminjam.')
    ->group(function () {

        // Route::get('/dashboard', [DashboardController::class, 'index'])
        //     ->name('dashboard');
        Route::get('/dashboard', function () { return view('peminjam.dashboard'); })->name('dashboard');

        // SARANA
        Route::get('/sarana', [PeminjamSaranaController::class, 'index'])
            ->name('sarana.index');

        Route::get('/sarana/{sarana}', [PeminjamSaranaController::class, 'show'])
            ->name('sarana.show');

        // PENGAJUAN
        Route::get('/pengajuan', [PeminjamPengajuanController::class, 'index'])
            ->name('pengajuan.index');

        Route::get('/pengajuan/create', [PeminjamPengajuanController::class, 'create'])
            ->name('pengajuan.create');

        Route::post('/pengajuan', [PeminjamPengajuanController::class, 'store'])
            ->name('pengajuan.store');

        Route::get('/pengajuan/{peminjaman}', [PeminjamPengajuanController::class, 'show'])
            ->name('pengajuan.show');

        Route::patch('/pengajuan/{peminjaman}/cancel', [PeminjamPengajuanController::class, 'cancel'])
            ->name('pengajuan.cancel');

        // PENGEMBALIAN
        Route::get('/pengembalian', [PeminjamPengembalianController::class, 'index'])
            ->name('pengembalian.index');

        Route::get('/pengembalian/{pengembalian}', [PeminjamPengembalianController::class, 'show'])
            ->name('pengembalian.show');

        // RIWAYAT
        Route::get('/riwayat', [RiwayatController::class, 'index'])
            ->name('riwayat.index');

        Route::get('/riwayat/{peminjaman}', [RiwayatController::class, 'show'])
            ->name('riwayat.show');
    });