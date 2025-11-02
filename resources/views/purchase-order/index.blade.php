@extends('layouts.layouts_dashboard')
@section('row')

@section('page-content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div
                    class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center align-items-start">

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
                            <input type="text" name="search" class="form-control" placeholder="Cari barang..." value="">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                            <!-- Tambahkan tombol reset jika ada nilai pencarian -->
                            {{-- @if(request('search'))
                                <a href="{{ route('barang.index') }}" class="btn btn-outline-danger" title="Hapus
                            Pencarian">
                            <i class="bi bi-x-lg"></i>
                            </a>
                            @endif --}}
                        </div>
                    </form>

                </div>

                <div class="card-body">
                    <table class="table table-hover" id="myTable12">
                        <thead>
                            <tr>

                                    <tr>
                                        <th>Po No</th>
                                        <th>Po Date</th>
                                        <th>Nama Supplier</th>
                                        <th>Estimasi Pengiriman</th>
                                        <th>Note</th>
                                        <th>Metode Bayar</th>
                                        <th>Status</th>
                                        <th>Currency</th>
                                        <th>Currency Rate</th>
                                        <th>Lampiran Permintaan</th>
                                        <th>Disetujui Oleh</th>
                                        <th>Disetujui tanggal</th>
                                        <th>Biaya Transportation</th>

                                        <th style="width: 150px;">Aksi</th>
                                    </tr>


                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data_purchase_orders as $data )

                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->po_date }}</td>
                                <td>{{ $data->supplier->name_suppliers }}</td>
                                <td>{{ $data->estimation_delivery_date }}</td>
                                <td>
                                    {{ !empty($data->note) ? $data->note : 'Tidak ada catatan' }}
                                </td>

                                <td>{{ $data->supplier->method_payment }}</td>
                                <td>{{ $data->status }}</td>
                                <td>{{ $data->currency }}</td>
                                <td>{{ $data->currency_rate }}</td>
                                <td>
                                    @if ($data->attachment)
                                    <img src="{{ asset('storage/' . $data->attachment) }}" alt="Attachment" width="60"
                                        height="60" style="object-fit: cover; border-radius: 6px;">
                                    @else
                                    <span class="text-muted">Tidak ada gambar</span>
                                    @endif
                                </td>

                                <td>
                                    <span
                                        class="badge {{ $data->approved_by === 'Approve' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $data->approved_by === 'Approve' ? 'Approved' : 'Not Approve' }}
                                    </span>
                                </td>

                                <td>
                                    @if (!empty($data->approved_at))
                                    {{ \Carbon\Carbon::parse($data->approved_at)->format('d M Y H:i') }}
                                    @else
                                    <span class="text-muted">Belum disetujui</span>
                                    @endif
                                </td>


                                <td>{{ $data->transportation_fee }}</td>
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
@endsection
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    $('#myTable12').DataTable();
});
</script>
@endpush

