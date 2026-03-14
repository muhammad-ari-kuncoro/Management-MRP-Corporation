@extends('layouts.layouts_dashboard')

@section('page-content')
<div class="container d-flex justify-content-center">
    <div class="col-md-8 col-lg-6">

        <div class="card shadow-sm mt-4">
            <div class="card-header text-center">
                <h4 class="mb-0">Form Tambah Data Permintaan Pekerjaan</h4>
            </div>

            <div class="col-12 mt-3">
                @include('layouts.component_alerts')
            </div>


            <div class="card-body">
                <form action="{{route('work-orders.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- Production Plan Code --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Production Plan Code</label>
                        <input type="text" name="work_order_code" class="form-control" value="{{ $generate_code_work }}"
                            required readonly disabled>
                        @error('work_order_code')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror

                    </div>

                    {{-- Nama Data Produk --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Data Produk</label>
                        <select class="js-example-basic-single form-select" name="product_id" required>
                            <option value="" disabled selected>Pilih Produk</option>

                            @if($data_product->count() > 0)
                            @foreach ($data_product as $data)
                            <option value="{{ $data->id ?? $data->product_id }}">
                                {{ $data->product_code ?? '' }} | {{ $data->product_name ?? $data->name ?? '' }}
                            </option>
                            @endforeach
                            @else
                            <option value="" disabled>Data kosong, harap tambahkan</option>
                            @endif

                            @error('product_id')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </select>
                    </div>

                    {{-- Data BOM Berdasarkan Status Completed --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Data BOM</label>
                        <select class="js-example-basic-single form-select" name="bom_id" required>
                            <option value="" disabled selected>Pilih BOM</option>

                            @php
                            $filteredBOM = $data_bom->where('status', 'Pending'); // atau 'Completed' sesuai DB
                            @endphp

                            @if($filteredBOM->count() > 0)
                            @foreach ($filteredBOM as $data)
                            <option value="{{ $data->id ?? $data->bom_id }}">
                                {{ $data->code_bom ?? $data->code ?? '' }} | {{ $data->status }}
                            </option>
                            @endforeach
                            @else
                            <option value="" disabled>Data kosong, harap tambahkan</option>
                            @endif

                            @error('bom_id')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </select>
                    </div>


                    {{-- No Refrences --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">No Refrences</label>
                        <input type="text" name="no_reference" class="form-control" placeholder="Masukkan No Refrensi">
                        @error('no_refrences')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror

                    </div>

                    {{-- Menggunakan onInput & onKeyDown untuk Mencegah Inoutan Character dan Simbol sejenisnya --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Qty Ordered</label>
                        <input type="number" name="qty_ordered" class="form-control"
                            placeholder="Masukkan jumlah Pesanan Produk" min="0"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            onkeydown="return event.keyCode !== 189 && event.keyCode !== 187 && event.keyCode !== 107 && event.keyCode !== 109;">
                        <small class="text-muted">Hanya angka (0–9), tidak bisa input huruf atau simbol</small>
                        @error('qty_ordered')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror

                    </div>



                    {{-- Menggunakan onInput & onKeyDown untuk Mencegah Inoutan Character dan Simbol sejenisnya --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Qty Completed</label>
                        <input type="number" name="qty_completed" class="form-control"
                            placeholder="Masukkan jumlah Produk Penyelesaian " min="0"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            onkeydown="return event.keyCode !== 189 && event.keyCode !== 187 && event.keyCode !== 107 && event.keyCode !== 109;">
                        <small class="text-muted">Hanya angka (0–9), tidak bisa input huruf atau simbol</small>
                        @error('qty_completed')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror

                    </div>

                    {{-- Tanggal Pengiriman Product --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tanggal Pengiriman Produk</label>
                        <input type="date" name="delivery_date_product" class="form-control">
                        @error('delivery_date_product')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Tombol --}}
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary px-4">
                            Tambah Data
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </div>
</div>
@endsection


{{-- CSS & JS --}}
@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function () {
        $('.js-example-basic-single').select2({
            width: '100%'
        });
    });

</script>
@endpush
