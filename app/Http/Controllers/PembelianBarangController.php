<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\DetailPembelianBarang;
use App\Models\HistoriBarang;
use App\Models\PembelianBarang;
use App\Models\Suplier;
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

    public function json(){
        $columns = ['id', 'tanggal', 'total_uang', 'total_barang' ];
        $orderBy = $columns[request()->input("order.0.column")];
        $data = PembelianBarang::select('id', 'tanggal', 'total_uang', 'total_barang');

        if(request()->input("search.value")){
            $data = $data->where(function($query){
                $query->whereRaw('total_uang like ? ', ['%'.request()->input("search.value").'%'])
                ->orWhereRaw('total_barang like ? ', ['%'.request()->input("search.value").'%']);
            });
        }

        $recordsFiltered = $data->get()->count();
        $data = $data->skip(request()->input('start'))->take(request()->input('length'))->orderBy($orderBy,request()->input("order.0.dir"))->get();
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
            'suplier' => Suplier::select('id', 'nama_perusahaan')->get(),
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
        $pembelian->suplier_id = $request->suplier_id;
        $pembelian->tanggal = date('Y-m-d H:i');
        $pembelian->total_barang = $request->jumlah_total;
        $pembelian->total_uang = $request->grand_total;
        $pembelian->save();

        foreach ($request->barang_id as $key => $value) {
            $data[] = [
                'pembelianbarang_id' => $pembelian->id,
                'barang_id' => $request->barang_id[$key],
                'harga' => $request->harga[$key],
                'jumlah' => $request->jumlah[$key],
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

    public function getBarang($id){
        try {
            $getsuplier = Suplier::select('nama_perusahaan', 'kode_perusahaan')->findOrFail($id);
            return response()->json(['status' => 200, 'suplier' => $getsuplier,'data' => Barang::select('id', 'nama_barang')->where('suplier_id', $id)->get()]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'List barang tidak ditemukan']);
        }
    }

    public function show($id)
    {
        try {
            $getbarang = Barang::select('id', 'nama_barang', 'kode_barang', 'harga_jual', 'stok_barang')->findOrFail($id);
            return response()->json(['data' => $getbarang]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Data barang tidak ditemukan'], 404);
        }
    }

    public function cetak($id) {
        $pembelian = PembelianBarang::with('suplier')->findOrFail($id);
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

    public function destroy($id)
    {
        PembelianBarang::destroy($id);
        return response()->json(['message' => 'Data pembelian barang berhasil di hapus']);
    }
}
