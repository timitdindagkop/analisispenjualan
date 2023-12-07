<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Pembeli;
use App\Models\PembelianBarang;
use App\Models\PenjualanBarang;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        return view('home.index', [
            'title' => 'Home',
            'barang' => Barang::select('id')->get()->count(),
            'penjualan' => PenjualanBarang::select('id')->get()->count(),
            'pembelian' => PembelianBarang::select('id')->get()->count(),
            'pembeli' => Pembeli::select('id')->get()->count(),
        ]);
    }

    public function analisis(){
        return view('analisis.index', [
            'title' => 'Analisis penjualan',
        ]);
    }
}
