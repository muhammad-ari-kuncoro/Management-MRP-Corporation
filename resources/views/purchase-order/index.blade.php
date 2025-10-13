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
                        <h4 class="mb-0 me-4">Data Purchase Order </h4>
                        <a href="{{ route('purchase-order-detail.index') }}" class="btn btn-primary icon icon-left">
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
                                        <th>Po No</th>
                                        <th>Po Date</th>
                                        <th>Nama Supplier</th>
                                        <th>Estimasi Pengiriman</th>
                                        <th>Note</th>
                                        <th>Kesepakatan Bayar</th>
                                        <th>Status</th>
                                        <th>Currency</th>
                                        <th>Currency Rate</th>
                                        <th>Attahment Image</th>
                                        <th>Approved By</th>
                                        <th>Approved At</th>
                                        <th>Biaya Transportation</th>
                                        <th>Data Jurnal</th>
                                        <th style="width: 150px;">Aksi</th>
                                    </tr>
                                </thead>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>jasdasd</td>
                                <td>asdsdasd</td>
                                <td>asdasdasd</td>
                                <td>asdasdasd</td>
                                <td>asdasdasd</td>
                                <td>asdasdasd</td>
                                <td>asdasdasd</td>
                                <td>asdasdas</td>
                                <td>asdasdas</td>
                                <td>asdsadas</td>
                                <td>asdasdas</td>
                                <td>asdsadas</td>
                                <td>asdasdasdd</td>
                                <td>dasasdasd</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <!-- Tombol Edit -->
                                        <a href="" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
