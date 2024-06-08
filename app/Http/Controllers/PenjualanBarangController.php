<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\CicilanPembeli;
use App\Models\DetailPenjualanBarang;
use App\Models\HistoriBarang;
use App\Models\Pembeli;
use App\Models\PenjualanBarang;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class PenjualanBarangController extends Controller
{

    public function index()
    {
        return view('penjualan.index', [
            'title' => 'Penjualan Barang'
        ]);
    }

    public function data($data)
    {
        // return $data;
        foreach ($data as $item) {
            $pembayarancicilan = CicilanPembeli::where('penjualanbarang_id', $item->id)->sum('jumlah_uang');
            // $pelunasan = $pembayarancicilan + $item->dp_cicilan - $item->total_uang;
            $result[] = [
                'id' => $item->id,
                'nama' => $item->pembeli->nama_pembeli,
                'tanggal' => $item->tanggal,
                'total_barang' => $item->total_barang,
                'total_uang' => $item->total_uang,
                'status_cicilan' => $item->status_cicilan,
                'status_bayar' => $item->status_bayar,
                'dp_cicilan' => $item->dp_cicilan,
            ];
        }

        return $result;
    }

    public function json()
    {
        $columns = ['id', 'pembeli_id', 'tanggal', 'total_uang', 'total_barang', 'status_cicilan', 'status_bayar', 'dp_cicilan'];
        $orderBy = $columns[request()->input("order.0.column")];
        $data = PenjualanBarang::select('id', 'pembeli_id', 'tanggal', 'total_uang', 'total_barang', 'status_cicilan', 'status_bayar', 'dp_cicilan');

        if (request()->input("search.value")) {
            $data = $data->where(function ($query) {
                $query->whereRaw('total_uang like ? ', ['%' . request()->input("search.value") . '%'])
                    ->orWhereRaw('total_barang like ? ', ['%' . request()->input("search.value") . '%']);
            });
        }

        $recordsFiltered = $data->get()->count();
        $data = $data->skip(request()->input('start'))->take(request()->input('length'))->orderBy($orderBy, request()->input("order.0.dir"))->get();

        $recordsTotal = $data->count();

        return response()->json([
            'draw' => request()->input('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $recordsTotal == 0 ? $data : $this->data($data)
        ]);
    }

    public function getBarang()
    {
        try {
            $barang = Barang::select('id', 'nama_barang');
            return response()->json(['data' => $barang]);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Data barang tidak ada']);
        }
    }

    public function create()
    {
        return view('penjualan.create', [
            'title' => 'Create Penjualan Barang',
            'pembeli' => Pembeli::select('id', 'nama_pembeli')->get(),
            'barang' => Barang::select('id', 'nama_barang')->get()
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate(
            [
                'barang_id' => 'required',
                'harga' => 'required',
                'jumlah' => 'required',
            ],
            [
                'barang_id.required' => 'Nama barang tidak boleh kosong',
                'harga.required' => 'Nama barang tidak boleh kosong',
                'jumlah.required' => 'Harga jual tidak boleh kosong',
            ]
        );

        $penjualan = new PenjualanBarang();
        $penjualan->id = intval((microtime(true) * 10000));
        $penjualan->pembeli_id = $request->pembeli_id;
        $penjualan->tanggal = $request->tanggal;
        $penjualan->total_barang = $request->jumlah_total;
        $penjualan->total_uang = $request->grand_total;
        $penjualan->status_cicilan = $request->status_cicilan;
        $penjualan->status_bayar = $request->status_cicilan == 'ya' ? "Belum lunas" : "Lunas";
        $penjualan->dp_cicilan = $request->dp_cicilan == null ? 0 : preg_replace('/[^0-9]/', '', $request->dp_cicilan);
        $penjualan->save();

        if ($request->status_cicilan == 'ya' && $request->dp_cicilan !== null) {
            $cicilan = new CicilanPembeli();
            $cicilan->penjualanbarang_id = $penjualan->id;
            $cicilan->id = intval((microtime(true) * 1000));
            $cicilan->urutan_cicilan = 1;
            $cicilan->jumlah_uang = $request->dp_cicilan == null ? 0 : preg_replace('/[^0-9]/', '', $request->dp_cicilan);
            $cicilan->save();
        }

        foreach ($request->barang_id as $key => $value) {
            $data[] = [
                'penjualanbarang_id' => $penjualan->id,
                'barang_id' => $request->barang_id[$key],
                'harga' => $request->harga[$key],
                'jumlah' => $request->jumlah[$key],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $barang = Barang::find($request->barang_id[$key]);
            $stok_barang = $barang->stok_barang;
            $barang->stok_barang = $stok_barang - $request->jumlah[$key];
            $barang->update();

            $history = new HistoriBarang();
            $history->kategori = "penjualan";
            $history->barang_id = $barang->id;
            $history->nama_barang = $barang->nama_barang;
            $history->jumlah = $request->jumlah[$key];
            $history->harga_barang = $request->harga[$key];
            $history->save();
        }
        DB::table('detail_penjualan_barangs')->insert($data);
        return response()->json(['message' => 'Pembelian barang berhasil dilakukan']);
    }

    public function show($id)
    {
        return view('penjualan.cicilan', [
            'title' => 'Cicilan pembeli',
            'data' => PenjualanBarang::with('pembeli')->select('id', 'pembeli_id', 'tanggal', 'total_barang', 'total_uang', 'status_cicilan', 'status_bayar', 'dp_cicilan')->findOrFail($id),
            'detail' => DetailPenjualanBarang::with('barang')->select('barang_id', 'jumlah', 'harga')->where('penjualanbarang_id', $id)->get(),
            'total_cicilan' => CicilanPembeli::where('penjualanbarang_id', $id)->sum('jumlah_uang')
        ]);
    }

    public function getCicilan($id)
    {
        $cicilan = CicilanPembeli::select('id', 'urutan_cicilan', 'jumlah_uang', 'created_at')->where('penjualanbarang_id', $id)->get();
        $penjualan = PenjualanBarang::find($id);

        $total_uang = $penjualan->total_uang;
        $total_cicilan = $total_uang - $cicilan->sum('jumlah_uang');
        return response()->json([
            'data' => $cicilan,
            'cicilan' => $cicilan->sum('jumlah_uang'),
            'kekurangan_uang' => $total_cicilan
        ]);
    }

    public function cetak($id)
    {
        return view('penjualan.print', [
            'title' => 'Print Penjualan',
            'data' => PenjualanBarang::with('pembeli')->select('id', 'pembeli_id', 'tanggal', 'total_barang', 'total_uang', 'status_cicilan', 'dp_cicilan')->findOrFail($id),
            'detail' => DetailPenjualanBarang::with('barang')->select('barang_id', 'jumlah', 'harga')->where('penjualanbarang_id', $id)->get(),
        ]);
    }

    public function storeCicilan(Request $request)
    {
        $request->validate(
            [
                'penjualanbarang_id' => 'required',
                'jumlah_uang' => 'required',
            ]
        );


        $cicilan = CicilanPembeli::where('penjualanbarang_id', $request->penjualanbarang_id)->get();
        $jumlah_cicilan = $cicilan->count();
        $jumlah_uang = preg_replace('/[^0-9]/', '', $request->jumlah_uang);
        $penjualanBarang = PenjualanBarang::find($request->penjualanbarang_id);

        if (($cicilan->sum('jumlah_uang') + $jumlah_uang) > $penjualanBarang->total_uang) {
            return response()->json(['message' => 'Pembayaran cicilan melebihi total uang'], 404);
        }

        $cicilan_pembeli = new CicilanPembeli();
        $cicilan_pembeli->id = intval((microtime(true) * 1000));
        $cicilan_pembeli->penjualanbarang_id = $request->penjualanbarang_id;
        $cicilan_pembeli->urutan_cicilan = $jumlah_cicilan + 1;
        $cicilan_pembeli->jumlah_uang = $jumlah_uang;
        $cicilan_pembeli->save();

        if (($penjualanBarang->dp_cicilan + $cicilan->sum('jumlah_uang') + $jumlah_uang) == $penjualanBarang->total_uang) {
            $penjualanBarang->status_bayar = "Lunas";
            $penjualanBarang->update();
        }
        return response()->json(['message' => 'Cicilan berhasil di bayarkan']);
    }

    public function destroyCicilan($id)
    {
        $cicilan = CicilanPembeli::find($id);
        $penjualan = PenjualanBarang::find($cicilan->penjualanbarang_id);
        $penjualan->status_bayar = "Belum lunas";
        $penjualan->update();
        $cicilan->delete();
        return response()->json(['message' => 'Cicilan berhasil dihapus']);
    }

    public function destroy($id)
    {
        $penjualan = PenjualanBarang::find($id);
        $detailPenjualan = DetailPenjualanBarang::where('penjualanbarang_id', $id)->get();
        foreach ($detailPenjualan as $dp) {

            $barang = Barang::find($dp->barang_id);
            $stok_barang = $barang->stok_barang;
            $barang->stok_barang = $stok_barang + $dp->jumlah;
            $barang->update();

            $history = new HistoriBarang();
            $history->kategori = "hapus_penjualan";
            $history->barang_id = $barang->id;
            $history->nama_barang = $barang->nama_barang;
            $history->jumlah = $dp->jumlah;
            $history->harga_barang = $dp->harga;
            $history->save();
        }
        $penjualan->delete();
        return response()->json(['message' => 'Data penjualan barang berhasil di hapus']);
    }
}
