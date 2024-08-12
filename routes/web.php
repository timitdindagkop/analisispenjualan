<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PembelianBarangController;
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\PenjualanBarangController;
use App\Http\Controllers\SuplierController;
use Illuminate\Support\Facades\Route;

route::get('/', [HomeController::class, 'index'])->middleware('auth');
route::get('/home', [HomeController::class, 'index'])->middleware('auth');
route::get('login', [AuthController::class, 'login'])->name('login')->middleware('guest');
route::post('auth', [AuthController::class, 'authenticate'])->name('auth')->middleware('guest');
route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

route::resource('/b', BarangController::class)->middleware('auth');
route::resource('/pe', PembeliController::class)->middleware('auth');
route::post('/json_b', [BarangController::class, 'json'])->name('json_b')->middleware('auth');
route::post('/json_pe', [PembeliController::class, 'json'])->name('json_pe')->middleware('auth');

// route pembelian barang
route::resource('/pb', PembelianBarangController::class)->middleware('auth');
route::get('/print_pb/{id}', [PembelianBarangController::class, 'cetak'])->middleware('auth');
route::get('/pb_detail/{id}', [PembelianBarangController::class, 'getDetail'])->middleware('auth');
route::post('/json_pb', [PembelianBarangController::class, 'json'])->name('json_pb')->middleware('auth');

// route penjualan barang
route::get('/get_pjb', [PenjualanBarangController::class, 'getBarang'])->middleware('auth');
route::get('/get_c/{id}', [PenjualanBarangController::class, 'getCicilan'])->name('get_c')->middleware('auth');
route::get('/print_pj/{id}', [PenjualanBarangController::class, 'cetak'])->name('print_pj')->middleware('auth');
route::post('/json_pj', [PenjualanBarangController::class, 'json'])->middleware('auth');
route::post('/store_cicilan', [PenjualanBarangController::class, 'storeCicilan'])->middleware('auth');
route::delete('/del_cicilan/{id}', [PenjualanBarangController::class, 'destroyCicilan'])->name('del_cicilan')->middleware('auth');
route::resource('/pj', PenjualanBarangController::class)->middleware('auth');

// laporan
route::get('/lpp', [LaporanController::class, 'pembeli'])->middleware('auth');
route::get('/lpp/{id}', [LaporanController::class, 'detailPembeli'])->middleware('auth');
route::get('/lpb', [LaporanController::class, 'bulanan'])->middleware('auth');
route::get('/lpbb', [LaporanController::class, 'bulanan_detail'])->middleware('auth');
route::get('/lb', [LaporanController::class, 'labaBersih'])->middleware('auth');
route::get('/json_lpb', [LaporanController::class, 'json_bulanan'])->middleware('auth');
// analisis
route::get('/an', [HomeController::class, 'analisis'])->name('analisis')->middleware('auth');
route::get('/getAnalisis', [HomeController::class, 'getAnalisis'])->name('getAnalisis')->middleware('auth');