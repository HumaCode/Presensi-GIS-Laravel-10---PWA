<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PresensiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::middleware(['guest:karyawan'])->group(function () {
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');
    Route::post('/proseslogin', [AuthController::class, 'proseslogin'])->name('proseslogin');
});


Route::middleware(['auth:karyawan'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/proseslogout', [AuthController::class, 'proseslogout']);

    // presensi
    Route::get('/presensi/create', [PresensiController::class, 'create'])->name('presensi.create');
    Route::post('/presensi/store', [PresensiController::class, 'store'])->name('presensi.store');

    // edit profil
    Route::get('/editprofil', [PresensiController::class, 'editprofil'])->name('profil.editprofil');
    Route::post('/updateprofil/{id}', [PresensiController::class, 'updateprofil'])->name('profil.updateprofil');

    // histori presensi
    Route::get('/histori/presensi', [PresensiController::class, 'histori'])->name('histori.presensi');
    Route::post('/histori/getHistori', [PresensiController::class, 'getHistori'])->name('histori.getHistori');

    // izin
    Route::get('/presensi/izin', [PresensiController::class, 'izin'])->name('izin.presensi');
    Route::get('/presensi/buatizin', [PresensiController::class, 'buatizin'])->name('buatizin.presensi');
    Route::post('/presensi/storeizin', [PresensiController::class, 'storeizin'])->name('storeizin.presensi');
});
