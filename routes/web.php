<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PembelianBarangController;
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\SuplierController;
use Illuminate\Support\Facades\Route;

route::get('/', [HomeController::class, 'index'])->middleware('auth');
route::get('/home', [HomeController::class, 'index'])->middleware('auth');
route::get('login', [AuthController::class, 'login'])->name('login')->middleware('guest');
route::post('auth', [AuthController::class, 'authenticate'])->name('auth')->middleware('guest');
route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

route::resource('/sp', SuplierController::class)->middleware('auth');
route::resource('/b', BarangController::class)->middleware('auth');
route::resource('/pe', PembeliController::class)->middleware('auth');
route::resource('/pb', PembelianBarangController::class)->middleware('auth');
route::post('/json_sp', [SuplierController::class, 'json'])->name('json_sp')->middleware('auth');
route::post('/json_b', [BarangController::class, 'json'])->name('json_b')->middleware('auth');
route::post('/json_pe', [PembeliController::class, 'json'])->name('json_pe')->middleware('auth');
route::post('/json_pb', [PembelianBarangController::class, 'json'])->name('json_pb')->middleware('auth');

// route pembelian
route::get('/get_barang/{id}', [PembelianBarangController::class, 'show'])->middleware('auth');
route::get('/get_lb/{id}', [PembelianBarangController::class, 'getBarang'])->middleware('auth');
route::get('/print_pb/{id}', [PembelianBarangController::class, 'cetak'])->middleware('auth');