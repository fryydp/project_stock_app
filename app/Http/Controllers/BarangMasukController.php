<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use App\Models\stok;
use App\Models\suplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarangMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = BarangMasuk::with(
            'getStok',
            'getSuplier',
            'getAdmin',
        );

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')){
            $query->whereBetween('Tanggal_Faktur',[ $request->tanggal_awal, $request->tanggal_akhir ]
        );

        }
        $query->orderBy('created_at', 'desc');
        $getdata = $query->paginate(10);

        return view('Barang.BarangMasuk.BarangMasuk', compact(
            'getdata'

        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $getnama_barang_id = stok::with('getSuplier')->get();

        return view('Barang.BarangMasuk.addBarangMasuk', compact(
            'getnama_barang_id',

        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_faktur' => 'required',
            'nama_barang_id' => 'required',
            'jumlah' => 'required',


            ]);

            $updateStok = stok::find($request->nama_barang_id);
            if ($request->filled('harga')){
                $harga_beli = $request->harga;
            } else {
                $harga_beli = $updateStok->harga;
            }

            $saveBarangMasuk = new BarangMasuk();
                $saveBarangMasuk->Tanggal_Faktur = $request->tanggal_faktur;
                $saveBarangMasuk->Nama_Barang_id = $request->nama_barang_id;
                $saveBarangMasuk->Harga_Beli = $harga_beli;
                $saveBarangMasuk->Jumlah_barang_masuk = $request->jumlah;
                $saveBarangMasuk->suplier_id = $updateStok->suplier_id;
                $saveBarangMasuk->Admin_id = Auth::user()->id;
                // dd($saveBarangMasuk);
            $saveBarangMasuk->save();

            $hitung = $updateStok->stok + $request->jumlah;
            $updateStok->stok = $hitung;
            $updateStok->save();

            return redirect('/barang-masuk')->with(
                'message',
                'BarangMasuk' . $request->Nama_Barang . 'ditambahkan'
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $barangMasuk = BarangMasuk::find($id);

      $get_Id_Stok = $barangMasuk->Nama_Barang_id;
      $get_Jumlah_barang_masuk = $barangMasuk->Jumlah_barang_masuk;

        $getItemBarang = stok::find($get_Id_Stok);
            $getStok = $getItemBarang->stok;

            $updateStok = $getStok - $get_Jumlah_barang_masuk;

            $getItemBarang->stok = $updateStok;
            $getItemBarang->save();

        $barangMasuk->delete();

        return redirect('/barang-masuk')->with(
            'message',
            'Data barang dihapus'
        );

    }
}
