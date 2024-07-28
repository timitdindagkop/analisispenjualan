<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\DetailPembelianBarang;
use App\Models\HistoriBarang;
use App\Models\PembelianBarang;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class PembelianBarangController extends Controller
{
    public function index()
    {
        return view('pembelian.index', [
            'title' => 'Pembelian Barang',
        ]);
    }

    public function json()
    {
        $columns = ['id', 'tanggal', 'total_uang', 'total_barang'];
        $orderBy = $columns[request()->input("order.0.column")];
        $data = PembelianBarang::with('DetailPembelianBarang')->select('id', 'tanggal', 'total_uang', 'total_barang')->orderBy('tanggal', 'DESC');

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
            'data' => $data
        ]);
    }

    public function create()
    {
        return view('pembelian.create', [
            'title' => 'Buat Pembelian Barang',
            'barang' => Barang::select('id', 'nama_barang')->get(),
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

        $pembelian = new PembelianBarang();
        $pembelian->id = intval((microtime(true) * 10000));
        $pembelian->tanggal = $request->tanggal;
        $pembelian->total_barang = $request->jumlah_total;
        $pembelian->total_uang = $request->grand_total;
        $pembelian->save();

        foreach ($request->barang_id as $key => $value) {
            $data[] = [
                'pembelianbarang_id' => $pembelian->id,
                'barang_id' => $request->barang_id[$key],
                'harga' => $request->harga[$key],
                'jumlah' => $request->jumlah[$key],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $barang = Barang::find($request->barang_id[$key]);
            $stok_barang = $barang->stok_barang;
            $barang->stok_barang = $stok_barang + $request->jumlah[$key];
            $barang->update();

            $history = new HistoriBarang();
            $history->kategori = "pembelian";
            $history->barang_id = $barang->id;
            $history->nama_barang = $barang->nama_barang;
            $history->jumlah = $request->jumlah[$key];
            $history->harga_barang = $request->harga[$key];
            $history->save();
        }
        DB::table('detail_pembelian_barangs')->insert($data);
        return response()->json(['message' => 'Pembelian barang berhasil dilakukan']);
    }

    public function cetak($id)
    {
        $pembelian = PembelianBarang::findOrFail($id);
        $detailPembelian = DetailPembelianBarang::with('barang')->where('pembelianbarang_id', $id)->get();
        return view('pembelian.print', [
            'title' => 'Cetak Pembelia Barang',
            'pembelian' => $pembelian,
            'detail_pembelian' => $detailPembelian
        ]);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function getDetail($id){
        $data = DetailPembelianBarang::with('barang')->select('id', 'pembelianbarang_id', 'barang_id', 'jumlah', 'harga')->where('pembelianbarang_id', $id)->get();
        return response()->json(['data' => $data]);
    }

    public function destroy($id)
    {
        $pembelian = PembelianBarang::find($id);
        $detailPembelian = DetailPembelianBarang::where('pembelianbarang_id', $id)->get();
        foreach ($detailPembelian as $dp) {

            $barang = Barang::find($dp->barang_id);
            $stok_barang = $barang->stok_barang;
            $barang->stok_barang = $stok_barang - $dp->jumlah;
            $barang->update();

            $history = new HistoriBarang();
            $history->kategori = "hapus_pembelian";
            $history->barang_id = $barang->id;
            $history->nama_barang = $barang->nama_barang;
            $history->jumlah = $dp->jumlah;
            $history->harga_barang = $dp->harga;
            $history->save();
        }
        $pembelian->delete();
        return response()->json(['message' => 'Data pembelian barang berhasil di hapus']);
    }
}
