<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PenjualanBarangController extends Controller
{

    public function index()
    {
        return view('penjualan.index', [
            'title' => 'Penjualan Barang'
        ]);
    }

    public function create()
    {
        return view('penjualan.create', [
            'title' => 'Create Penjualan Barang'
        ]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
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
