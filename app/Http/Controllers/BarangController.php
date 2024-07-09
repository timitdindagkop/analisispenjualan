<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BarangController extends Controller
{
    public function index()
    {
        return view('master.barang.index', [
            'title' => 'Barang',
        ]);
    }

    public function json()
    {
        $columns = ['id', 'kode_barang', 'nama_suplier', 'nama_barang', 'harga_jual', 'harga_beli', 'stok_barang'];
        $orderBy = $columns[request()->input("order.0.column")];
        $data = Barang::select('id', 'kode_barang', 'nama_suplier', 'nama_barang', 'harga_jual', 'harga_beli', 'stok_barang');

        if (request()->input("search.value")) {
            $data = $data->where(function ($query) {
                $query->whereRaw('kode_barang like ? ', ['%' . request()->input("search.value") . '%'])
                    ->orWhereRaw('nama_suplier like ? ', ['%' . request()->input("search.value") . '%'])
                    ->orWhereRaw('nama_barang like ? ', ['%' . request()->input("search.value") . '%'])
                    ->orWhereRaw('harga_jual like ? ', ['%' . request()->input("search.value") . '%'])
                    ->orWhereRaw('harga_beli like ? ', ['%' . request()->input("search.value") . '%'])
                    ->orWhereRaw('stok_barang like ? ', ['%' . request()->input("search.value") . '%']);
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

    public function validasi($request)
    {
        $request->validate(
            [
                'nama_suplier' => 'required',
                'nama_barang' => 'required',
                'kode_barang' => 'required',
                'harga_jual' => 'required',
                'harga_beli' => 'required',
                'stok_barang' => 'required'
            ],
            [
                'nama_suplier.required' => 'Nama suplier tidak boleh kosong',
                'nama_barang.required' => 'Nama barang tidak boleh kosong',
                'kode_barang.required' => 'Nama barang tidak boleh kosong',
                'harga_jual.required' => 'Harga jual tidak boleh kosong',
                'harga_beli.required' => 'Harga beli tidak boleh kosong',
                'stok_barang.required' => 'Stok barang tidak boleh kosong',
            ]
        );
    }

    public function store(Request $request)
    {
        // $this->validasi($request);
        $request->validate(
            [
                'nama_suplier' => 'required',
                'nama_barang' => 'required',
                'kode_barang' => 'required|unique:barangs',
                'harga_jual' => 'required',
                'harga_beli' => 'required',
                'stok_barang' => 'required'
            ],
            [
                'nama_suplier.required' => 'Nama suplier tidak boleh kosong',
                'nama_barang.required' => 'Nama barang tidak boleh kosong',
                'kode_barang.required' => 'Kode barang tidak boleh kosong',
                'kode_barang.unique' => 'Kode barang sudah ada',
                'harga_jual.required' => 'Harga jual tidak boleh kosong',
                'harga_beli.required' => 'Harga beli tidak boleh kosong',
                'stok_barang.required' => 'Stok barang tidak boleh kosong',
            ]
        );
        // menyimpan data barang
        $barang = new Barang();
        $barang->id = Str::uuid()->toString();
        $barang->kode_barang = $request->kode_barang;
        $barang->nama_suplier = $request->nama_suplier;
        $barang->nama_barang = $request->nama_barang;
        $barang->harga_beli = preg_replace('/[^0-9]/', '', $request->harga_beli);
        $barang->harga_jual = preg_replace('/[^0-9]/', '', $request->harga_jual);
        $barang->stok_barang = $request->stok_barang;
        $barang->save();
        return response()->json(['message' => 'Barang baru berhasil di buat']);
    }

    public function show($id)
    {
        try {
            $getbarang = Barang::select('id', 'nama_barang', 'nama_suplier', 'kode_barang', 'harga_jual', 'harga_beli', 'stok_barang')->findOrFail($id);
            return response()->json(['data' => $getbarang]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Data barang tidak ditemukan'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $this->validasi($request);
        // menyimpan data barang
        try {
            $update_barang = Barang::findOrFail($id);
            $update_barang->nama_suplier = $request->nama_suplier;
            $update_barang->nama_barang = $request->nama_barang;
            $update_barang->kode_barang = $request->kode_barang;
            $update_barang->harga_beli = preg_replace('/[^0-9]/', '', $request->harga_beli);
            $update_barang->harga_jual = preg_replace('/[^0-9]/', '', $request->harga_jual);
            $update_barang->stok_barang = $request->stok_barang;
            $update_barang->update();
            return response()->json(['message' => 'Barang berhasil di ubah',]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Data barang tidak ditemukan'], 404);
        }
    }

    public function destroy($id)
    {
        Barang::destroy($id);
        return response()->json(['message' => 'Barang berhasil di hapus']);
    }
}
