<?php

// use App\Http\Controllers\Auth\loginController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SidebarController;
use App\Http\Controllers\UserController;
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


Route::middleware(['guest'])->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/', [LoginController::class, 'login']);
});

Route::middleware(['auth'])->group(function () {
    Route::middleware(['admin'])->group(function () {

        // Kelola User
        Route::get('/user', [UserController::class, 'index']);
        Route::post('/user', [UserController::class, 'store']);
        Route::get('/user/getAll', [UserController::class, 'getAll']);
        Route::get('/user/{id}', [UserController::class, 'show']);
        Route::put('/user/{id}', [UserController::class, 'update']);
        Route::delete('/user/{id}', [UserController::class, 'destroy']);


        //produk
        Route::get('/produk', [ProdukController::class, 'index']);
        Route::get('/produk/getAll', [ProdukController::class, 'getAll']);
        Route::post('/produk', [ProdukController::class, 'store']);
        Route::get('/produk/{id}', [ProdukController::class, 'show']);
        Route::put('/produk/{id}', [ProdukController::class, 'update']);
        Route::delete('/produk/{id}', [ProdukController::class, 'destroy']);

        //kategori
        Route::get('/kategori', [KategoriController::class, 'index']);
        Route::get('/kategori/getAll', [KategoriController::class, 'getAll']);
        Route::post('/kategori', [KategoriController::class, 'store']);
        Route::get('/kategori/getById/{kategori}', [KategoriController::class, 'show']);
        Route::put('/kategori/{id}', [KategoriController::class, 'update']);
        Route::delete('/kategori/{id}', [KategoriController::class, 'destroy']);
        Route::get('/kategori/list', [KategoriController::class, 'listKategori']);

        // generate laporan
        Route::get('/laporan', [LaporanController::class, 'index']);
        Route::get('/laporan/getAll', [LaporanController::class, 'getAll']);
        Route::get('/laporan/{id}', [LaporanController::class, 'show']);
        Route::post('/laporan/getByRange', [LaporanController::class, 'getByRange']);
    });

    //dashboard
    Route::get('/dash', function () {
        return view('dashboard.index');
    });
    Route::post('/dash/getByRange', [DashboardController::class, 'getByRange']);


    //pelanggan
    Route::get('/pelanggan', [PelangganController::class, 'index']);
    Route::get('/pelanggan/getAll', [PelangganController::class, 'getAll']);
    Route::post('/pelanggan', [PelangganController::class, 'store']);
    Route::delete('/pelanggan/{id}', [PelangganController::class, 'destroy']);
    Route::put('/pelanggan/{id}', [PelangganController::class, 'update']);
    Route::get('/pelanggan/getById/{id}', [PelangganController::class, 'show']);

    // transaksi


    //Penjualan
    Route::get('/penjualan', function () {
        return view('penjualan.index');
    });
    Route::get('/penjualan/invoice/{id}', [PenjualanController::class, 'invoice'])->name('penjualan.invoice');
    Route::get('/penjualan/{id}', [PenjualanController::class, 'getProdukByBarcode']);
    Route::post('/listBarang', [PenjualanController::class, 'store']);


    Route::get('/logout', [LoginController::class, 'logout']);
});


Route::get('/sidebar', [SidebarController::class, 'getSidebar'])->name('sidebar.get');
