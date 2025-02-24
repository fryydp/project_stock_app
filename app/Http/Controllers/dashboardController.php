<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\stok;
use App\Models\suplier;

class dashboardController extends Controller
{
    public function index()
    {
        $getSuplier = suplier::count();
        $getPelanggan = pelanggan::count();
        $getStok = stok::count();
        $getPendapatan = barangKeluar::sum('sub_total');
        return view('Dashboard.dashboard', compact(
            'getSuplier',
            'getPelanggan',
            'getStok',
            'getPendapatan',
        ));
    }
}
