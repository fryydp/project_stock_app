@extends('main')

@section('title')
Barang Masuk
@endsection

@section('content')
<div class="container-fluid">
    <h3 class="mt-2 mb-3">Barang Masuk</h3>
    <nav aria-label="breadcrumb" class="mb-1">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Barang Masuk</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex">
                        <div class="pt-1 w-100">
                            <strong>Barang Masuk</strong>
                        </div>
                        <div class="w-100 text-end">
                            <a href="{{url('/barang-masuk')}}" class="btn btn-outline-primary btn-sm">
                                Refresh Data
                                <i class="bi bi-arrow-clockwise"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <div class="mt-3 mb-4 container-fluid">
                        <div class="row">
                            <div class="col-6">
                                <form action="" method="get">
                                    <div class="row">
                                        <div class="col">
                                            <input
                                                type="date"
                                                value="{{ old('tanggal_awal') }}"
                                                name="tanggal_awal"
                                                id="tanggal_awal"
                                                class="form-control"/>
                                            <sub>
                                                <Strong>Tanggal Awal</Strong>
                                            </sub>
                                        </div>
                                        <div class="col">
                                            <input
                                                type="date"
                                                value="{{ old('tanggal_akhir') }}"
                                                name="tanggal_akhir"
                                                id="tanggal_akhir"
                                                class="form-control"/>
                                            <sub>
                                                <Strong>Tanggal Akir</Strong>
                                            </sub>
                                        </div>
                                        <div class="col-2">
                                            <button type="submit" class="btn btn-primary">Cari
                                                <i class="bi bi-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-6">
                                @if (Session::has('message'))
                                <div class="alert alert-success" id="flash-message">
                                    <strong>
                                        {{Session::get('message')}}
                                    </strong>
                                </div>
                                <script>
                                    setTimeout(function () {
                                        document
                                            .getElementById('flash-message')
                                            .style
                                            .display = 'none';
                                    }, {{ session('timeout', 5000) }});
                                </script>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="mt-4 col">
                                <a
                                    href="{{ url('/barang-masuk/add') }}"
                                    class="btn btn-primary btn-md rounded-5">
                                    <i class="bi bi-plus"></i>
                                    Tambah Barang Masuk
                                </a>
                            </div>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <th class="text-center">No</th>
                            <th class="text-center">Tanggal Faktur</th>
                            <th class="text-center">Nama Barang</th>
                            <th class="text-center">Suplier</th>
                            <th class="">Harga Beli</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center">Admin</th>
                            <th class="text-center">Cabang</th>
                            <th class="text-center">Aksi</th>
                        </thead>
                        <tbody>
                            @foreach ($getdata as $item )
                            <tr>
                                <td>
                                    {{ (($getdata->currentPage() -1) * $getdata->perPage()) + $loop->iteration}}
                                </td>
                                <td class="text-center">{{Carbon\Carbon::parse($item->Tanggal_Faktur)->format('d-m-Y')}}</td>
                                <td class="text-center">{{$item->getStok->nama_Barang}}</td>
                                <td class="text-center">{{$item->getSuplier->name_suplier}}</td>
                                <td>{{'Rp' . number_format($item->harga, 0, ',', ',')}}</td>
                                <td class="text-center">{{$item->Jumlah_barang_masuk}}</td>
                                <td class="text-center">{{$item->getAdmin->name}}</td>
                                <td class="text-center">{{$item->getStok->cabang}}</td>
                                <td class="text-center">
                                    <a
                                        href="{{url('/barang-masuk')}}/{{$item->id}}"
                                        class="btn btn-danger"
                                        onclick="return confirm('Menghapus data dapat menyebabkan beberapa kekeliruan dalam data stok!!!, yakin menghapus data?')"
                                        tittle="Hapus">
                                        <i class="bi-trash"></i>
                                    </a>
                                </td>
                            </tr>

                            @endforeach
                        </tbody>

                    </table>
                    {{$getdata->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
