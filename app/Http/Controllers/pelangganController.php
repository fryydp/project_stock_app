<?php

namespace App\Http\Controllers;

use App\Models\pelanggan;
use Illuminate\Http\Request;

class pelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $data = pelanggan::where('name_pelanggan', 'like', '%' . $search . '%')
        ->orWhere('telp', 'like', '%' . $search . '%')
        ->paginate();

        return view('Pelanggan.pelanggan', compact ('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Pelanggan.addPelanggan');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([

            'nama_pelanggan' => 'required',
            'kota' => 'required',
            'alamat' => 'required',
            'telp' => 'required|numeric',
            'provinsi' => 'required',
            'jenis_kelamin' => 'required',

            ], [
            'nama_pelanggan_requierd' => 'Data Wajib diisi',
            'kota.requierd' => 'Data Wajib diisi',
            'alamat.requierd' => 'Data Wajib diisi',

            'telp.requierd' => 'Data Wajib diisi',
            'telp.numeric' => 'Data berupa angka',

            'provinsi' => 'Data Wajib diisi',
            'jenis_kelamin' => 'Data Wajib diisi',

            ]);

            $savePelanggan = new pelanggan();
            $savePelanggan->name_pelanggan = $request->nama_pelanggan;
            $savePelanggan->kota = $request->kota;
            $savePelanggan->alamat = $request->alamat;
            $savePelanggan->telp = $request->telp;
            $savePelanggan->provinsi = $request->provinsi;
            $savePelanggan->jenis_kelamin = $request->jenis_kelamin;
            $savePelanggan->save();

            return redirect('/pelanggan')->with(
                'message',
                'Data' .  $request->nama_pelanggan . 'berhasil ditambahkan'
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
        $data = pelanggan::find($id);
       return view('Pelanggan.editPelanggan', compact(
        'data'
       ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([

            'nama_pelanggan' => 'required',
            'kota' => 'required',
            'alamat' => 'required',
            'telp' => 'required|numeric',
            'provinsi' => 'required',
            'jenis_kelamin' => 'required',

            ], [
            'nama_pelanggan_requierd' => 'Data Wajib diisi',
            'kota.requierd' => 'Data Wajib diisi',
            'alamat.requierd' => 'Data Wajib diisi',

            'telp.requierd' => 'Data Wajib diisi',
            'telp.numeric' => 'Data berupa angka',

            'provinsi' => 'Data Wajib diisi',
            'jenis_kelamin' => 'Data Wajib diisi',

            ]);

            $savePelanggan = pelanggan::find($id);
            $savePelanggan->name_pelanggan = $request->nama_pelanggan;
            $savePelanggan->kota = $request->kota;
            $savePelanggan->alamat = $request->alamat;
            $savePelanggan->telp = $request->telp;
            $savePelanggan->provinsi = $request->provinsi;
            $savePelanggan->jenis_kelamin = $request->jenis_kelamin;
            $savePelanggan->save();

            return redirect('/pelanggan')->with(
                'message',
                'Data' .  $request->nama_pelanggan . 'berhasil di update'
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = pelanggan::find($id);
        $data->delete();

        return redirect()->back()->with(
            'message',
            'Data Pelanggan berhasil dihapus!!!'
        );
    }
}
