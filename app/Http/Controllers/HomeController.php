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
        $getbulan = $this->getBulan();
        $penjualan_chart = [
            PenjualanBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', "01")->sum('total_uang'),
            PenjualanBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', "02")->sum('total_uang'),
            PenjualanBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', "03")->sum('total_uang'),
            PenjualanBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', "04")->sum('total_uang'),
            PenjualanBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', "05")->sum('total_uang'),
            PenjualanBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', "06")->sum('total_uang'),
            PenjualanBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', "07")->sum('total_uang'),
            PenjualanBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', "08")->sum('total_uang'),
            PenjualanBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', "09")->sum('total_uang'),
            PenjualanBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', "10")->sum('total_uang'),
            PenjualanBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', "11")->sum('total_uang'),
            PenjualanBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', "12")->sum('total_uang'),
        ];

        $pembelian_chat = [
            PembelianBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', "01")->sum('total_uang'),
            PembelianBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', "02")->sum('total_uang'),
            PembelianBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', "03")->sum('total_uang'),
            PembelianBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', "04")->sum('total_uang'),
            PembelianBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', "05")->sum('total_uang'),
            PembelianBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', "06")->sum('total_uang'),
            PembelianBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', "07")->sum('total_uang'),
            PembelianBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', "08")->sum('total_uang'),
            PembelianBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', "09")->sum('total_uang'),
            PembelianBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', "10")->sum('total_uang'),
            PembelianBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', "11")->sum('total_uang'),
            PembelianBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', "12")->sum('total_uang'),
        ];
        
        return view('home.index', [
            'title' => 'Home',
            'barang' => Barang::select('id')->get()->count(),
            'penjualan' => PenjualanBarang::select('id')->get()->count(),
            'pembelian' => PembelianBarang::select('id')->get()->count(),
            'pembeli' => Pembeli::select('id')->get()->count(),
            'penjualan_chart' => implode(",",$penjualan_chart),
            'pembelian_chat' => implode(",",$pembelian_chat),
        ]);
    }

    public function getBulan(){
        $getbulan[] = [
            'jan' => ['bulan' => 'Januari','urutan' => '01',],
            'feb' => ['bulan' => 'Februari','urutan' => '02',],
            'mar' => ['bulan' => 'Maret','urutan' => '03',],
            'apr' => ['bulan' => 'April','urutan' => '04',],
            'mei' => ['bulan' => 'Mei','urutan' => '05',],
            'jun' => ['bulan' => 'Juni','urutan' => '06',],
            'jul' => ['bulan' => 'Juli','urutan' => '07',],
            'agt' => ['bulan' => 'Agustus','urutan' => '08',],
            'sep' => ['bulan' => 'September','urutan' => '09',],
            'okt' => ['bulan' => 'Oktober','urutan' => '10',],
            'nov' => ['bulan' => 'November','urutan' => '11',],
            'des' => ['bulan' => 'Desember','urutan' => '12',],
        ];

        return $getbulan;
    }

    public function analisis(){
        // $getbulan = $this->getBulan();
        // $no = 1;
        // foreach($getbulan[0] as $b){
        //     $data[] = [
        //         'no' => $no,
        //         'bulan' => $b['bulan'],
        //         'penjualan' => PenjualanBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', $b['urutan'])->sum('total_barang'),
        //     ];
        //     $no++;
        // }
        
        for($i = 1; $i < 21 ; $i++) {
            $day = "-". $i . " day";
            $tanggal = date('Y-m-d', strtotime($day));
            $data[] = [
                'no' => $i,
                'bulan' => date('d-m-Y', strtotime($day)),
                'penjualan' => PenjualanBarang::whereDate('tanggal', $tanggal)->sum('total_barang'),                
            ];
        }

        // return $data;

        return view('analisis.index', [
            'title' => 'Analisis penjualan',
            'penjualan' => $data,
            'totalno' => 0,
            'totalx' => 0,
            'totaly' => 0,
            'totalx2' => 0,
            'totaly2' => 0,
            'totalxy' => 0,

            'konstanta_a' => 0,
            'koefisien_b' => 0,

            'nilaiY' => 0,
        ]);
    }
}
