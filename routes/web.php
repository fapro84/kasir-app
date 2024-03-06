<?php

// use App\Http\Controllers\Auth\loginController;

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PelangganController;
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

        //pelanggan
        Route::get('/pelanggan', [PelangganController::class, 'index']);
        Route::get('/pelanggan/getAll', [PelangganController::class, 'getAll']);
        Route::post('/pelanggan', [PelangganController::class, 'store']);
    });

    //dashboard
    Route::get('/dash', function () {
        return view('dashboard.index');
    });


    // transaksi
    Route::get('/transaksi', function () {
        return view('transaksi.index');
    });


    Route::get('/logout', [LoginController::class, 'logout']);
});


Route::get('/sidebar', [SidebarController::class, 'getSidebar'])->name('sidebar.get');
