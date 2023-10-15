<?php

namespace App\Http\Controllers;

use App\Models\Suplier;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SuplierController extends Controller
{

    public function index()
    {
        return view('master.suplier.index', [
            'title' => 'Suplier'
        ]);
    }

    public function json(){
        $columns = ['id', 'kode_perusahaan', 'nama_perusahaan', 'alamat', 'telepon' ];
        $orderBy = $columns[request()->input("order.0.column")];
        $data = Suplier::select('id', 'kode_perusahaan', 'nama_perusahaan', 'alamat', 'telepon');

        if(request()->input("search.value")){
            $data = $data->where(function($query){
                $query->whereRaw('kode_perusahaan like ? ', ['%'.request()->input("search.value").'%'])
                ->orWhereRaw('nama_perusahaan like ? ', ['%'.request()->input("search.value").'%'])
                ->orWhereRaw('alamat like ? ', ['%'.request()->input("search.value").'%']);
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
    public  function validasi($request){
        $request->validate(
            [
                'kode_perusahaan' => 'required',
                'nama_perusahaan' => 'required',
                'alamat' => 'required',
            ]
        );
    }

    public function store(Request $request)
    {
        $this->validasi($request);
        $suplier = new Suplier();
        $suplier->id = intval((microtime(true) * 1000));
        $suplier->kode_perusahaan = $request->kode_perusahaan;
        $suplier->nama_perusahaan = $request->nama_perusahaan;
        $suplier->alamat = $request->alamat;
        $suplier->telepon = $request->telepon;
        $suplier->save();
        return response()->json([
            'status' => 200,
            'message' => 'Data Suplier baru berhasail di tambahkan'
        ]);
    }

    public function show($id)
    {
        try{
            $getsuplier = Suplier::findOrFail($id);
            return response()->json(['data' => $getsuplier]);
        }catch(ModelNotFoundException $e){
            return response()->json(['message' => 'Data suplier tidak di temukan'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $this->validasi($request);
        try{
            $update_suplier = Suplier::findOrFail($id);
            $update_suplier->kode_perusahaan = $request->kode_perusahaan;
            $update_suplier->nama_perusahaan = $request->nama_perusahaan;
            $update_suplier->alamat = $request->alamat;
            $update_suplier->telepon = $request->telepon;
            $update_suplier->update();
            return response()->json(['message' => 'Suplier berhasil di ubah']);
        }catch(ModelNotFoundException $e){
            return response()->json(['message' => 'Data suplier tidak di temukan'], 404);
        }
    }

    public function destroy($id)
    {
        Suplier::destroy($id);
        return response()->json(['message' => 'Data suplier berhasil di hapus']);
    }
}
