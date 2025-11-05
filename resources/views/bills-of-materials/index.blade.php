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
                        <a href="" class="btn btn-primary icon icon-left">
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
                    <table class="table table-hover" id="myTable6">
                        <thead>
                            <tr>
                                        <th>No</th>
                                        <th>Kode BOM</th>
                                        <th>Nama Kebutuhan Product</th>
                                        <th>Revisi</th>
                                        <th>Nama Items</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                            </tr>
                        </thead>
                        <tbody>
                            <!-- Contoh Data Statis -->
                            <tr>
                                <td>asdasdasd</td>
                                <td>asdasdasd</td>
                                <td>asdasdasd</td>
                                <td>asdasdasd</td>
                                <td>asdasdasd</td>
                                <td>asdasdasd</td>
                                <td>

                                    <div class="d-flex gap-2">
                                        <!-- Tombol Edit -->
                                        <a href="" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    </div>
                                </td>
                                </td>
                            </tr>

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
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    $('#myTable6').DataTable();
});

</script>
@endpush

