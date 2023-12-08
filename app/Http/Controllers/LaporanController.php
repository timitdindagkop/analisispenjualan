<?php

namespace App\Http\Controllers;

use App\Models\Pembeli;
use App\Models\PembelianBarang;
use App\Models\PenjualanBarang;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function pembeli(){
        $pembeli = Pembeli::select('id', 'nama_pembeli')->get();
        foreach($pembeli as $p){
            $data[] = [
                'nama_pembeli' => $p->nama_pembeli,
                'total_pembelian' => PenjualanBarang::where('pembeli_id', $p->id)->whereMonth('tanggal', date('m'))->whereYear('tanggal', date('Y'))->sum('total_uang'),
                'total_barang' => PenjualanBarang::where('pembeli_id', $p->id)->whereMonth('tanggal', date('m'))->whereYear('tanggal', date('Y'))->sum('total_barang'),
            ];
        }
        return view('laporan.perpembeli', [
            'title' => 'Laporan perPembeli',
            'data' => $data
        ]);
    }

    public function bulanan(){
        return view('laporan.perbulan', [
            'title' => 'Laporan bulanan',
        ]);
    }

    public function bulanan_detail(){
        $month = request('bulan');
        switch ($month) {
            case '01': $bulan = "Januari"; break;
            case '02': $bulan = "Feburari"; break;
            case '03': $bulan = "Maret"; break;
            case '04': $bulan = "April"; break;
            case '05': $bulan = "Mei"; break;
            case '06': $bulan = "Juni"; break;
            case '07': $bulan = "Juli"; break;
            case '08': $bulan = "Agustus"; break;
            case '09': $bulan = "September"; break;
            case '10': $bulan = "Oktober"; break;
            case '11': $bulan = "November"; break;
            case '12': $bulan = "Desember"; break;
            default: $bulan = "Bulan"; break;
        }

        $penjualan = PenjualanBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', $month)->get();
        $pembelian = PembelianBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', $month)->get();

        return view('laporan.perbulan_detail', [
            'title' => 'Laporan bulan '. $bulan,
            'penjualan' => $penjualan,
            'pembelian' => $pembelian,
        ]);
    }

    public function json_bulanan(){
        $data[] = [
            'total' => [
                'penjualan' => PenjualanBarang::whereYear('tanggal', date('Y'))->sum('total_uang'),
                'pembelian' => PembelianBarang::whereYear('tanggal', date('Y'))->sum('total_uang')
            ],
            'jan' => [
                'penjualan' => PenjualanBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', '01')->sum('total_uang'),
                'pembelian' => PembelianBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', '01')->sum('total_uang')
            ],
            'feb' => [
                'penjualan' => PenjualanBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', '02')->sum('total_uang'),
                'pembelian' => PembelianBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', '02')->sum('total_uang')
            ],
            'mar' => [
                'penjualan' => PenjualanBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', '03')->sum('total_uang'),
                'pembelian' => PembelianBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', '03')->sum('total_uang')
            ],
            'apr' => [
                'penjualan' => PenjualanBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', '04')->sum('total_uang'),
                'pembelian' => PembelianBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', '04')->sum('total_uang')
            ],
            'mei' => [
                'penjualan' => PenjualanBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', '05')->sum('total_uang'),
                'pembelian' => PembelianBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', '05')->sum('total_uang')
            ],
            'jun' => [
                'penjualan' => PenjualanBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', '06')->sum('total_uang'),
                'pembelian' => PembelianBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', '06')->sum('total_uang')
            ],
            'jul' => [
                'penjualan' => PenjualanBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', '07')->sum('total_uang'),
                'pembelian' => PembelianBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', '07')->sum('total_uang')
            ],
            'agt' => [
                'penjualan' => PenjualanBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', '08')->sum('total_uang'),
                'pembelian' => PembelianBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', '08')->sum('total_uang')
            ],
            'sep' => [
                'penjualan' => PenjualanBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', '09')->sum('total_uang'),
                'pembelian' => PembelianBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', '09')->sum('total_uang')
            ],
            'okt' => [
                'penjualan' => PenjualanBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', '10')->sum('total_uang'),
                'pembelian' => PembelianBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', '10')->sum('total_uang')
            ],
            'nov' => [
                'penjualan' => PenjualanBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', '11')->sum('total_uang'),
                'pembelian' => PembelianBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', '11')->sum('total_uang')
            ],
            'des' => [
                'penjualan' => PenjualanBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', '12')->sum('total_uang'),
                'pembelian' => PembelianBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', '12')->sum('total_uang')
            ],
        ];

        return response()->json([
            'data' => $data,
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

    public function labaBersih(){
        $getbulan = $this->getBulan();
        foreach($getbulan[0] as $b){
            $data[] = [
                'bulan' => $b['bulan'],
                'laba' => PenjualanBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', $b['urutan'])->sum('total_uang') - PembelianBarang::whereYear('tanggal', date('Y'))->whereMonth('tanggal', $b['urutan'])->sum('total_uang'),
            ];
        }
        
        return view('laporan.laba_bersih', [
            'title' => 'Laporan laba bersih',
            'laba' => $data,
        ]);
    }
}
