<?php

// use App\Http\Controllers\Auth\loginController;

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SidebarController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

Route::middleware(['guest'])->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/', [LoginController::class, 'login']);
});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware(['auth'])->group(function () {
    Route::middleware(['admin'])->group(function () {
        //produk
        Route::get('/produk', [ProdukController::class, 'index']);
        Route::get('/produk/getAll', [ProdukController::class, 'getAll']);
        Route::post('/produk', [ProdukController::class, 'store']);
        Route::get('/produk/{id}', [ProdukController::class, 'show']);
        Route::delete('/produk/{id}', [ProdukController::class, 'destroy']);

       
    });

     //kategori
     Route::get('/kategori', [KategoriController::class, 'index']);
     Route::get('/kategori/getAll', [KategoriController::class, 'getAll']);
     Route::post('/kategori', [KategoriController::class, 'store']);
     Route::get('/kategori/getById/{kategori}', [KategoriController::class, 'show']);
     Route::put('/kategori/{id}', [KategoriController::class, 'update']);
     Route::delete('/kategori/{id}', [KategoriController::class, 'destroy']);
     Route::get('/kategori/list', [KategoriController::class, 'listKategori']);


    // transaksi
    Route::get('/transaksi', function () {
        return view('transaksi.index');
    });
});

Route::get('/sidebar', [SidebarController::class, 'getSidebar'])->name('sidebar.get');

Route::get('/logout', [LoginController::class, 'logout']);
