@extends('layouts.layouts_dashboard')
@section('row')

@section('page-content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center align-items-start">

                    <!-- Judul dan Tombol Tambah Data -->
                    <div class="d-flex align-items-center mb-3 mb-md-0">
                        <h4 class="mb-0 me-4">Data Master Barang</h4>
                        <a href="{{ route('items.create') }}" class="btn btn-primary icon icon-left">
                            <i class="bi bi-plus-circle-fill"></i>
                            Tambah Data
                        </a>
                    </div>

                    <!-- Input Search (ditempatkan di kanan) -->
                    <form action="" method="GET" class="d-flex" role="search">
                        <div class="input-group">
                            <input
                                type="text"
                                name="search"
                                class="form-control"
                                placeholder="Cari barang..."
                                value=""
                            >
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                            <!-- Tambahkan tombol reset jika ada nilai pencarian -->
                            {{-- @if(request('search'))
                                <a href="{{ route('barang.index') }}" class="btn btn-outline-danger" title="Hapus Pencarian">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                            @endif --}}
                        </div>
                    </form>

                </div>

                <div class="card-body">
                    <table class="table table-hover" id="table1">
                        <thead>
                            <tr>
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Brg</th>
                                        <th>Nama Brg</th>
                                        <th>Spesification Brg</th>
                                        <th>Type Brg</th>
                                        <th>Harga Jual</th>
                                        <th>Stock Awal</th>
                                        <th>HPP</th>
                                        <th>Kategory</th>
                                        <th>Status Brg</th>
                                        <th>Cabang Supplier</th>
                                        <th>Minim Stock</th>
                                        <th>Konversion Items</th>
                                        <th>Berat Items</th>
                                        <th>Deskripsi</th>
                                        <th style="width: 150px;">Aksi</th>
                                    </tr>
                                </thead>

                            </tr>
                        </thead>
                        <tbody>
                            <!-- Contoh Data Statis -->
                            @foreach ($item_all as $data )

                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->kd_item }}</td>
                                <td>{{ $data->name_item }}</td>
                                <td>{{ $data->spesification }}</td>
                                <td>{{ $data->type }}</td>
                                <td>{{ $data->price_item }}</td>
                                <td>{{ $data->qty }}</td>
                                <td>{{ $data->weight_item }}</td>
                                <td>{{ $data->hpp }}</td>
                                <td>{{ $data->category }}</td>
                                <td>
                                    <span class="badge {{ $data->status_item == 'Active' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $data->status_item }}
                                    </span>
                                </td>
                                <td>{{ $data->branchCompany->name_branch_company ?? '-' }}</td>
                                <td>{{ $data->minim_stok }}</td>
                                <td>{{ $data->konversion_items_carbon }}</td>
                                <td>{{ $data->description }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <!-- Tombol Edit -->
                                        <a href="" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection
