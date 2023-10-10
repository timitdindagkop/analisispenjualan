<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\PembelianBarang;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
            'barang' => Barang::select('id', 'nama_barang')->get()
        ]);
    }

    public function store(Request $request)
    {
        //
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

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
