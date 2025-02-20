<?php

namespace App\Http\Controllers;

use App\Models\suplier;
use App\Models\User;
use Illuminate\Http\Request;

class suplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $search = $request->input('search');

    // Fix the LIKE query and add pagination per page parameter
    $data = suplier::where('name_suplier', 'LIKE', '%' . $search . '%')
        ->orWhere('telp', 'LIKE', '%' . $search . '%')
        ->paginate(10); // Assuming you want 10 items per page

    // dd($data); // This will dump the paginated results

    return view('Suplier.suplier', compact('data'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Suplier.addSuplier');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([

        'nama_suplier' => 'required',
        'email' => 'required',
        'alamat' => 'required',
        'telp' => 'required|numeric',
        'tgl_terdaftar' => 'required',
        'status' => 'required',

        ], [
        'nama_suplier.requierd' => 'Data Wajib diisi',
        'email.requierd' => 'Data Wajib diisi',
        'alamat.requierd' => 'Data Wajib diisi',

        'telp.requierd' => 'Data Wajib diisi',
        'telp.numeric' => 'Data berupa angka',

        'tgl_terdaftar.requierd' => 'Data Wajib diisi',
        'status.requierd' => 'Data Wajib diisi',

        ]);

        $saveSuplier = new suplier();
        $saveSuplier->name_suplier = $request->nama_suplier;
        $saveSuplier->email = $request->email;
        $saveSuplier->alamat = $request->alamat;
        $saveSuplier->telp = $request->telp;
        $saveSuplier->tgl_terdaftar = $request->tgl_terdaftar;
        $saveSuplier->status = $request->status;
        $saveSuplier->save();

        return redirect('/suplier')->with(
            'message',
            'Data' .  $request->nama_suplier . ' Berhasil ditambahkan'
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
        $data = suplier::find($id);
       return view('Suplier.editSuplier', compact(
        'data'
       ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([

            'nama_suplier' => 'required',
            'email' => 'required',
            'alamat' => 'required',
            'telp' => 'required|numeric',
            'tgl_terdaftar' => 'required',
            'status' => 'required',

            ], [
            'nama_suplier.requierd' => 'Data Wajib diisi',
            'email.requierd' => 'Data Wajib diisi',
            'alamat.requierd' => 'Data Wajib diisi',

            'telp.requierd' => 'Data Wajib diisi',
            'telp.numeric' => 'Data berupa angka',

            'tgl_terdaftar.requierd' => 'Data Wajib diisi',
            'status.requierd' => 'Data Wajib diisi',

            ]);

            $saveSuplier = suplier::find($id);
            $saveSuplier->name_suplier = $request->nama_suplier;
            $saveSuplier->email = $request->email;
            $saveSuplier->alamat = $request->alamat;
            $saveSuplier->telp = $request->telp;
            $saveSuplier->tgl_terdaftar = $request->tgl_terdaftar;
            $saveSuplier->status = $request->status;
            $saveSuplier->save();

            return redirect('/suplier')->with(
                'message',
                'Data' .  $request->nama_suplier . ' Berhasil diperbaharui'
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = suplier::find($id);
        $data->delete();

        return redirect()->back()->with(
            'message',
            'Data Suplier berhasil dihapus!!!'
        );
    }
}
