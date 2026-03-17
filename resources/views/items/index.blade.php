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

                         <form action="{{ route('items.item.export-excel') }}" method="GET"
                            class="d-inline-flex gap-2 align-items-end">
                            <div>
                                <label class="form-label mb-1" style="font-size:12px;">Bulan</label>
                                <select name="bulan" class="form-select form-select-sm">
                                    @foreach (range(1, 12) as $m)
                                        <option value="{{ $m }}" {{ date('n') == $m ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="form-label mb-1" style="font-size:12px;">Tahun</label>
                                <input type="number" name="tahun" class="form-control form-control-sm"
                                    value="{{ date('Y') }}" min="2020" max="2099" style="width:90px;">
                            </div>
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="bi bi-file-earmark-excel me-1"></i> Export Excel
                            </button>
                        </form>

                </div>

                <div class="card-body">
                    <table class="table table-hover" id="myTable15">
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
                                        <th>Aksi</th>
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
                                        <a href="{{route('items.edit',$data->id)}}" class="btn btn-sm btn-warning">
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
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    $('#myTable15').DataTable();
});

</script>
@endpush

