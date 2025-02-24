<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluar;
use App\Models\pelanggan;
use App\Models\stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarangKeluarController extends Controller
{

    function index(Request $request){


        $query = BarangKeluar::with(
            'getStok',
            'getPelanggan',
            'getUser',
        );

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')){
            $query->whereBetween('tgl_buat',[ 
                $request->tanggal_awal,
                 $request->tanggal_akhir 
                 ]);

        }
        $query->orderBy('created_at', 'desc');
        $getBarangKeluar = $query->paginate(10);
        $getTotalPendapatan = BarangKeluar::sum('sub_total');

        return view('Barang.BarangKeluar.BarangKeluar', compact(
            'getBarangKeluar',
            'getTotalPendapatan'

        ));
    }

    function create(){

        $data = barangKeluar::all();

        $lastId = barangKeluar::max('id');
        $lastId = $lastId ?  $lastId : 0;

         if ($data->isEmpty()) {
            $nextId = $lastId + 1;
            $date = now()->format('d/m/y');
            $kode_transaksi = 'TRK' . $nextId . '/' . $date;

            $pelanggan = pelanggan::all();

            return view('Barang.BarangKeluar.addBarangKeluar', compact(
                'data',
                'kode_transaksi',
                'pelanggan',

            ));
         }

         $latestItem = barangkeluar::latest()->first();
         $id = $latestItem->id;
         $date = $latestItem->created_at->format('d/m/y');
         $kode_transaksi = 'TRK' .  ($id+1) . '/' . $date;
         $pelanggan = pelanggan::all();

         return view('Barang.BarangKeluar.addBarangKeluar', compact(
             'data',
             'kode_transaksi',
             'pelanggan',
         ));


    }


    public function store(Request $request)
    {
        $request->validate([
            'tgl_faktur' => 'required',
            'tgl_jatuh_tempo' => 'required',
            'pelanggan_id' => 'required',
            'jenis_pembayaran' => 'required',

        ]);

        ([
        'tgl_faktur.required' => 'Data wajib diisi',
        'tgl_jatuh_tempo.required' => 'Data wajib diisi',
        'pelanggan_id.required' => 'Data wajib diisi',
        'jenis_pembayaran.required' => 'Data wajib diisi',
        ]);

        $kode_transaksi = $request->kode_transaksi;
        $tgl_faktur = $request->tgl_faktur;
        $tgl_jatuh_tempo = $request->tgl_jatuh_tempo;
        $pelanggan_id = $request->pelanggan_id;
        
        $getNamaPelanggan = pelanggan::find($pelanggan_id);
        $namaPelanggan = $getNamaPelanggan->name_pelanggan;
        $jenis_pembayaran = $request->jenis_pembayaran;

        $getBarang = stok::all();

        return view('Transaksi.transaksi', compact(
            'kode_transaksi',
            'tgl_faktur',
            'tgl_jatuh_tempo',
            'pelanggan_id',
            'namaPelanggan',
            'jenis_pembayaran',
            'getBarang',
        ));

    }

    public function saveBarangKeluar(Request $request)
    {

        $request->validate([
          
            'kode_transaksi' => 'required',
            'tgl_faktur' => 'required',
            'tgl_jatuh_tempo' => 'required',
            'pelanggan_id' => 'required',
            'jenis_pembayaran' => 'required',
            'barang_id' => 'required',
            'jumlah_beli' => 'required',
            'harga_jual' => 'required',

        ]);
           
        $save = new BarangKeluar();


        $save->kode_transaksi = $request->kode_transaksi;
        $save->tgl_faktur = $request->tgl_faktur;
        $save->tgl_jatuh_tempo = $request->tgl_jatuh_tempo;
        $save->pelanggan_id = $request->pelanggan_id;
        $save->jenis_pembayaran = $request->jenis_pembayaran;
        $save->barang_id = $request->barang_id;
        $save->jumlah_beli = $request->jumlah_beli;
        $save->harga_jual = $request->harga_jual;

        $getStokData = stok::find($request->barang_id);
        $getJumlahStok = $getStokData->stok;
        $getStokData->stok = $getJumlahStok - $request->jumlah_beli;
        $getStokData->save();

        $diskon = $request->diskon;
        $nilaiDiskon = $diskon/100;

        if ($diskon){
            $save->diskon = $request->diskon;
            $hitung = $request->jumlah_beli * $request->harga_jual;
            $totalDiskon = $hitung * $nilaiDiskon;
            $subTotal = $hitung - $totalDiskon;
            $save->sub_total = $subTotal;
        }else{
            $hitung = $request->jumlah_beli * $request->harga_jual;
            $save->sub_total = $hitung;

        }


        $save->user_id = Auth::user()->id;
        $save->tgl_buat = $request->tgl_faktur;
        $save->save();

        return redirect('/barang-keluar')->with(
            'message',
            'Barang keluar add'
        );
        

    }

    public function print($id)
    {
        $dataPrint = barangKeluar::with(
            'getStok',
            'getPelanggan'
        )->find($id);

        return view('Nota.Nota', compact(
            'dataPrint'
        ));
    }

    public function destroy($id)
    {
        $delete = barangKeluar::find($id);
        $getID_Barang_keluar = $delete->barang_id;
        $getJumlah_barang_keluar = $delete->jumlah_beli;

        $update = stok::find($getID_Barang_keluar);
        $getStok = $update->stok;

        $jumlah_Baru = $getStok + $getJumlah_barang_keluar;
        $update->stok = $jumlah_Baru;
        $update->save();
        $delete->delete();

        return redirect()->back()->with(
            'message',
            'Data berhasill dihapus!!'
        );
        
    }




}
