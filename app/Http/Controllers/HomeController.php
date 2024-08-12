<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\DetailPenjualanBarang;
use App\Models\Pembeli;
use App\Models\PembelianBarang;
use App\Models\PenjualanBarang;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $getbulan = $this->getBulan();
        $tgl = [];
        $uang = [];
        $beli = [];
        for($i = 0; $i < 7 ; $i++) {
            $day = "-". $i . " day";
            $tanggal = date('Y-m-d', strtotime($day));
            array_push($tgl, '"'.date('d/m/Y', strtotime($day)).'"') ;
            array_push($uang, PenjualanBarang::whereDate('tanggal', $tanggal)->sum('total_barang')) ;        
            array_push($beli, PembelianBarang::whereDate('tanggal', $tanggal)->sum('total_barang')) ;        
        }
        // return implode(', ', $tgl);
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

        $date = date('d');
        $month = date('m');
        $year = date('Y');
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

        return view('home.index', [
            'title' => 'Home',
            'barang' => Barang::select('id')->get()->count(),
            'penjualan' => PenjualanBarang::select('id')->get()->count(),
            'pembelian' => PembelianBarang::select('id')->get()->count(),
            'pembeli' => Pembeli::select('id')->get()->count(),
            'penjualan_chart' => implode(",",$penjualan_chart),
            'pembelian_chat' => implode(",",$pembelian_chat),
            'tgl' => implode(', ', $tgl),
            'beli' => implode(', ', $beli),
            'uang' => implode(', ', $uang),
            'tanggal' => $date . ' ' . $bulan . ' ' . $year
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
        
        // for($i = 1; $i < 21 ; $i++) {
        //     $day = "-". $i . " day";
        //     $tanggal = date('Y-m-d', strtotime($day));
        //     $data[] = [
        //         'no' => $i,
        //         'bulan' => date('d-m-Y', strtotime($day)),
        //         'tgl' => date('dm', strtotime($day)),
        //         'penjualan' => PenjualanBarang::whereDate('tanggal', $tanggal)->sum('total_barang'),                
        //     ];
        // }

        // $data = $this->get5kedelai();
        // return $data;

        return view('analisis.index', [
            'title' => 'Analisis penjualan',
            'penjualan' => $this->get5kedelai(),
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

    public function get5kedelai(){
        // for($i = 1; $i < 21 ; $i++) {
            
        //     $day = "-". $i . " day";
        //     $tanggal = date('Y-m-d', strtotime($day));

        //     $sipx = 0; $sipx2 = 0; $sipy = 0; $sipy2 = 0; $sipxy = 0;
        //     $penjualansip = DetailPenjualanBarang::whereDate('created_at', '=',$tanggal)->where('barang_id', 'bd9b56e6-4a80-46d7-b774-82427d7b3774')->sum('jumlah');
        //     $datasip[] = [
        //         'no' => $i,
        //         'bulan' => date('d-m-Y', strtotime($day)),
        //         'tgl' => date('dm', strtotime($day)),
        //         'penjualan' => $penjualansip,                
        //     ];
        //     $sipx += $i;
        //     $sipx2 += $i*$i;
        //     $sipy += $penjualansip;
        //     $sipy2 += $penjualansip*$penjualansip;
        //     $sipxy += $i*$penjualansip;
        //     return $penjualansip;
        //     $konsa_sip = (($sipy*$sipx2) - ($sipy*$sipxy)) / (($sipx*$sipx2) - ($sipx*$sipx));
        //     $koefb_sip = (($sipx*$sipxy) - ($sipx*$sipy)) / (($sipx*$sipx2) - ($sipx*$sipx) );        
        //     $Y_sip = abs($konsa_sip) + ($koefb_sip*22);   
        //     ############################################################################################
            
        //     $sgrx = 0; $sgrx2 = 0; $sgry = 0; $sgry2 = 0; $sgrxy = 0;
        //     $penjualansgr = DetailPenjualanBarang::whereDate('created_at', $tanggal)->where('barang_id', 'abc49e26-ffc0-46bf-bba1-754ae062435a')->sum('jumlah');
        //     $datasgr[] = [
        //         'no' => $i,
        //         'bulan' => date('d-m-Y', strtotime($day)),
        //         'tgl' => date('dm', strtotime($day)),
        //         'penjualan' => $penjualansgr,                
        //     ];
        //     $sgrx += $i;
        //     $sgrx2 += $i*$i;
        //     $sgry += $penjualansgr;
        //     $sgry2 += $penjualansgr*$penjualansgr;
        //     $sgrxy += $i*$penjualansgr;

        //     $konsa_sgr = (($sgry*$sgrx2) - ($sgry*$sgrxy)) / (($sgrx*$sgrx2) - ($sgrx*$sgrx));
        //     $koefb_sgr = (($sgrx*$sgrxy) - ($sgrx*$sgry)) / (($sgrx*$sgrx2) - ($sgrx*$sgrx) );        
        //     $Y_sgr = abs($konsa_sgr) + ($koefb_sgr*22);
            
        //     ############################################################################################
            
        //     $mbrx = 0; $mbrx2 = 0; $mbry = 0; $mbry2 = 0; $mbrxy = 0;
        //     $penjualanmbr = DetailPenjualanBarang::whereDate('created_at', $tanggal)->where('barang_id', 'f58cc48c-069b-49ae-95ac-84bf8c987975')->sum('jumlah');
        //     $datambr[] = [
        //         'no' => $i,
        //         'bulan' => date('d-m-Y', strtotime($day)),
        //         'tgl' => date('dm', strtotime($day)),
        //         'penjualan' => $penjualanmbr,                
        //     ];
        //     $mbrx += $i;
        //     $mbrx2 += $i*$i;
        //     $mbry += $penjualanmbr;
        //     $mbry2 += $penjualanmbr*$penjualanmbr;
        //     $mbrxy += $i*$penjualanmbr;

        //     $konsa_mbr = (($mbry*$mbrx2) - ($mbry*$mbrxy)) / (($mbrx*$mbrx2) - ($mbrx*$mbrx));
        //     $koefb_mbr = (($mbrx*$mbrxy) - ($mbrx*$mbry)) / (($mbrx*$mbrx2) - ($mbrx*$mbrx) );        
        //     $Y_mbr = abs($konsa_mbr) + ($koefb_mbr*22);
            
        //     ############################################################################################
            
        //     $sbsx = 0; $sbsx2 = 0; $sbsy = 0; $sbsy2 = 0; $sbsxy = 0;
        //     $penjualansbs = DetailPenjualanBarang::whereDate('created_at', $tanggal)->where('barang_id', 'bdbcb169-ae70-4071-92d0-9c6caccd3e63')->sum('jumlah');
        //     $datasbs[] = [
        //         'no' => $i,
        //         'bulan' => date('d-m-Y', strtotime($day)),
        //         'tgl' => date('dm', strtotime($day)),
        //         'penjualan' => $penjualansbs,                
        //     ];
        //     $sbsx += $i;
        //     $sbsx2 += $i*$i;
        //     $sbsy += $penjualansbs;
        //     $sbsy2 += $penjualansbs*$penjualansbs;
        //     $sbsxy += $i*$penjualansbs;

        //     $konsa_sbs = (($sbsy*$sbsx2) - ($sbsy*$sbsxy)) / (($sbsx*$sbsx2) - ($sbsx*$sbsx));
        //     $koefb_sbs = (($sbsx*$sbsxy) - ($sbsx*$sbsy)) / (($sbsx*$sbsx2) - ($sbsx*$sbsx) );        
        //     $Y_sbs = abs($konsa_sbs) + ($koefb_sbs*22);
            
        //     ############################################################################################
            
        //     $tulipx = 0; $tulipx2 = 0; $tulipy = 0; $tulipy2 = 0; $tulipxy = 0;
        //     $penjualantulip = DetailPenjualanBarang::whereDate('created_at', $tanggal)->where('barang_id', 'c1c7cea1-636c-4345-818b-a2dc774b9088')->sum('jumlah');
        //     $datatulip[] = [
        //         'no' => $i,
        //         'bulan' => date('d-m-Y', strtotime($day)),
        //         'tgl' => date('dm', strtotime($day)),
        //         'penjualan' => $penjualantulip,                
        //     ];
        //     $tulipx += $i;
        //     $tulipx2 += $i*$i;
        //     $tulipy += $penjualantulip;
        //     $tulipy2 += $penjualantulip*$penjualantulip;
        //     $tulipxy += $i*$penjualantulip;

        //     $konsa_tulip = (($tulipy*$tulipx2) - ($tulipy*$tulipxy)) / (($tulipx*$tulipx2) - ($tulipx*$tulipx));
        //     $koefb_tulip = (($tulipx*$tulipxy) - ($tulipx*$tulipy)) / (($tulipx*$tulipx2) - ($tulipx*$tulipx) );        
        //     $Y_tulip = abs($konsa_tulip) + ($koefb_tulip*22);

        //     return ['y_sip' => $Y_sip, 'y_sgr' => $Y_sgr, 'y_mbr' => $Y_mbr, 'y_sbs' => $Y_sbs, 'y_tulip' => $Y_tulip];
        // }
        
        $barang_data = [
            'bd9b56e6-4a80-46d7-b774-82427d7b3774' => 'SIP',
            'abc49e26-ffc0-46bf-bba1-754ae062435a' => 'SGR',
            'f58cc48c-069b-49ae-95ac-84bf8c987975' => 'MBR',
            'bdbcb169-ae70-4071-92d0-9c6caccd3e63' => 'SBS',
            'c1c7cea1-636c-4345-818b-a2dc774b9088' => 'TULIP',
        ];
    
        $results = [];
    
        foreach ($barang_data as $barang_id => $barang_name) {
            $x = 0; $x2 = 0; $y = 0; $y2 = 0; $xy = 0;
    
            for ($i = 1; $i < 21; $i++) {
                $day = "-$i day";
                $tanggal = date('Y-m-d', strtotime($day));
                $penjualan = DetailPenjualanBarang::whereDate('created_at', $tanggal)
                    ->where('barang_id', $barang_id)
                    ->sum('jumlah');
    
                $x += $i;
                $x2 += $i * $i;
                $y += $penjualan;
                $y2 += $penjualan * $penjualan;
                $xy += $i * $penjualan;
            }
    
            $konsa = (($y * $x2) - ($y * $xy)) / (($x * $x2) - ($x * $x));
            $koefb = (($x * $xy) - ($x * $y)) / (($x * $x2) - ($x * $x));
            $Y = abs($konsa) + ($koefb * 22);
    
            $results[] = [
                'barang_id' => $barang_id,
                'barang_name' => $barang_name,
                'Y' => $Y,
            ];
        }
    
        return $results;
    }


    public function getAnalisis(){
        for($i = 1; $i < 21 ; $i++) {
            
            $day = "-$i day";
            $tanggal = date('Y-m-d', strtotime($day));
            
            $data[] = [
                'no' => $i,
                'bulan' => date('d-m-Y', strtotime($day)),
                'tgl' => date('dm', strtotime($day)),
                'penjualan' => DetailPenjualanBarang::whereDate('created_at', $tanggal)->where('barang_id', request('merk'))->sum('jumlah'),                
            ];
        }
        return response()->json(['data' => $data]);
    }
}
