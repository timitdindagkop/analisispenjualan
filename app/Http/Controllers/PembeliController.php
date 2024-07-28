<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pembeli;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PembeliController extends Controller
{
    public function index()
    {
        return view('master.pembeli.index', [
            'title' => 'Pembeli'
        ]);
    }

    public function json(){
        $columns = ['id', 'kode_pembeli', 'nama_pembeli', 'alamat', 'telepon' ];
        $orderBy = $columns[request()->input("order.0.column")];
        $data = Pembeli::select('id', 'kode_pembeli', 'nama_pembeli', 'alamat', 'telepon');

        if(request()->input("search.value")){
            $data = $data->where(function($query){
                $query->whereRaw('kode_pembeli like ? ', ['%'.request()->input("search.value").'%'])
                ->orWhereRaw('nama_pembeli like ? ', ['%'.request()->input("search.value").'%'])
                ->orWhereRaw('alamat like ? ', ['%'.request()->input("search.value").'%'])
                ->orWhereRaw('telepon like ? ', ['%'.request()->input("search.value").'%']);
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

    public function validasi($request){
        $request->validate(
            [
                'nama_pembeli' => 'required',
                'alamat' => 'required',
                'telepon' => 'required',
            ],
            [
                'nama_pembeli.required' => 'Nama pembeli tidak boleh kosong',
                'alamat.required' => 'alamat pembeli tidak boleh kosong',
                'telepon.required' => 'Nomor telepon tidak boleh kosong',
            ]
        );
    }

    public function store(Request $request)
    {
        // $this->validasi($request);
        $request->validate(
            [
                'nama_pembeli' => 'required|unique:pembelis',
                'alamat' => 'required',
                'telepon' => 'required',
            ],
            [
                'nama_pembeli.required' => 'Nama pembeli tidak boleh kosong',
                'nama_pembeli.unique' => 'Nama sudah ada, silahkan tambahkan penanda',
                'alamat.required' => 'alamat pembeli tidak boleh kosong',
                'telepon.required' => 'Nomor telepon tidak boleh kosong',
            ]
        );
        // menyimpan data pembeli
        $pembeli = new Pembeli();
        $pembeli->id = Str::uuid()->toString();
        $pembeli->kode_pembeli = intval((microtime(true) * 1000));
        $pembeli->nama_pembeli = $request->nama_pembeli;
        $pembeli->telepon = $request->telepon;
        $pembeli->alamat = $request->alamat;
        $pembeli->save();
        return response()->json(['message' => 'Pembeli baru berhasil di buat']);
    }

    public function show($id)
    {
        try {
            $getpembeli = Pembeli::findOrFail($id);
            return response()->json(['data' => $getpembeli]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Data pembeli tidak ditemukan'], 404);
        }
        
    }

    public function update(Request $request, $id)
    {
        $this->validasi($request);
        // menyimpan data pembeli
        try {
            $update_pembeli = Pembeli::findOrFail($id);
            $update_pembeli->nama_pembeli = $request->nama_pembeli;
            $update_pembeli->telepon = $request->telepon;
            $update_pembeli->alamat = $request->alamat;
            $update_pembeli->update();
            return response()->json(['message' => 'Pembeli berhasil di ubah']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Data pembeli tidak ditemukan'], 404);
        }
    }

    public function destroy($id)
    {
        Pembeli::destroy($id);
        return response()->json(['message' => 'Pembeli berhasil di hapus']);
    }
}
