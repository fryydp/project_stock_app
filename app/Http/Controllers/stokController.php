<?php

namespace App\Http\Controllers;

use App\Models\suplier;
use App\Models\stok;
use Illuminate\Http\Request;

class stokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $getData = stok::with('getSuplier')

        ->where('kode_barang', 'like', '%' . $search . '%')
        ->orWhere('nama_Barang', 'like', '%' . $search . '%')
        ->paginate();

        return view('Stok.stok', compact ('getData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $getSuplier = suplier::all();

        return view('Stok.addStok', compact(
            'getSuplier'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'kode_barang' => 'required',
        'nama_barang' => 'required',
        'harga' => 'required',
        'stok' => 'required',
        'suplier' => 'required',
        'cabang' => 'required',

        ]);

        $saveStok = new stok();
        $saveStok->kode_barang = $request->kode_barang;
        $saveStok->nama_barang = $request->nama_barang;
        $saveStok->harga = $request->harga;
        $saveStok->stok = $request->stok;
        $saveStok->suplier_id = $request->suplier;
        $saveStok->cabang = $request->cabang;
        $saveStok->save();

        return redirect('/stok')->with(
            'message',
            'stok' . $request->nama_barang . 'ditambahkan'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $getDataStokId = stok::with('getSuplier')
        ->find($id);
// Suggested code may be subject to a license. Learn more: ~LicenseLog:579837108.
        $suplier = suplier::all();
       return view('Stok.editStok', compact(
        'getDataStokId',
        'suplier'
       ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'kode_barang' => 'required',
            'nama_barang' => 'required',
            'harga' => 'required',
            'stok' => 'required',
            'suplier' => 'required',
            'cabang' => 'required',

            ]);

            $saveStok = stok::with('getSuplier')->find($id);
            $saveStok->kode_barang = $request->kode_barang;
            $saveStok->nama_barang = $request->nama_barang;
            $saveStok->harga = $request->harga;
            $saveStok->stok = $request->stok;
            $saveStok->suplier_id = $request->suplier;
            $saveStok->cabang = $request->cabang;
            $saveStok->save();

            return redirect('/stok')->with(
                'message',
                'stok' . $request->nama_barang . 'diperbaharui'
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // $getData = stok::find($id);
        // $getData->delete();

        // return redirect()->back()->with(
        //     'message',
        //     'stok berhasil dihapus!!!'
        // );
    }
}
