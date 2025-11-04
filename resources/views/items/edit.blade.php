@extends('layouts.layouts_dashboard')
@section('row')

@section('page-content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- Card Header untuk Halaman Tambah Data -->
                <div class="card-header">
                    <h4>Form Edit Barang</h4>
                </div>

                <!-- Card Body berisi Form Input -->
                <div class="card-body">

                    {{-- Form input --}}
                    <form action="{{route('items.update',$itemsDataById->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="kd_item" class="form-label fw-semibold">Kode Item Barang</label>
                                <input id="kd_item" type="text" name="kd_item" class="form-control"
                                    placeholder="Masukkan Nama cabang Perusahaan" value="{{$itemsDataById->kd_item}}">
                                @error('kd_item')
                                <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="name_item" class="form-label fw-semibold">Nama Item Barang</label>

                                <textarea id="name_item" name="name_item" class="form-control" rows="3"
                                    placeholder="Masukkan Nama Barang" required>{{$itemsDataById->name_item}}</textarea>
                                @error('name_item')
                                <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="spesification" class="form-label fw-semibold">Spesifikasi Barang</label>
                                <input id="spesification" type="text" name="spesification" class="form-control"
                                    placeholder="Masukkan Spesifikasi Barang" value="{{$itemsDataById->spesification}}"
                                    required>

                                @error('spesification')
                                <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="type" class="form-label fw-semibold">Type Barang</label>
                                <input id="type" type="text" name="text" class="form-control"
                                    placeholder="Masukkan Type Barang" value="{{$itemsDataById->type}}" required>

                                @error('type')
                                <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="qty" class="form-label fw-semibold">qty Barang</label>
                                <input id="qty" type="number" name="text" class="form-control"
                                    placeholder="Masukkan Type Barang" value="{{$itemsDataById->qty}}" required>

                                @error('type')
                                <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="weight_item" class="form-label fw-semibold">Ukuran Item</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">+Kg</span>
                                    <input id="weight_item" type="text" name="weight_item" class="form-control"
                                        placeholder="Masukkan No telp Cabang Perusahaan"
                                        value="{{$itemsDataById->weight_item}}" required>
                                </div>
                                @error('weight_item')
                                <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>



                            <div class="mb-3">
                                <div class="col-md-6">
                                    <label>Harga Jual (Rp)</label>
                                    <input type="number" name="price_item" id="price_item" class="form-control"
                                        placeholder="Cth: 150.000 DSB" min="1" value="{{$itemsDataById->price_item}}">
                                </div>

                                <div class="col-md-6">
                                    <label>Stok Awal</label>
                                    <input type="number" name="qty" id="qty" class="form-control" placeholder="Cth: 100"
                                        min="1" value="{{$itemsDataById->qty}}">
                                </div>

                                <div class="col-md-6">
                                    <label for="hpp" class="form-label">HPP (%)</label>
                                    <div class="input-group">
                                        <input type="number" name="hpp" id="hpp" class="form-control"
                                            placeholder="Masukkan persentase HPP" min="0" max="100" step="0.01" required
                                            min="1" value="{{$itemsDataById->hpp}}">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="category" class="form-label">Kategori Barang</label>
                                        <select name="category" id="category" class="form-select" required>
                                            <option value="" disabled>-- Pilih Kategori Barang --</option>
                                            <option value="Raw Material"
                                                {{ $itemsDataById->category == 'Raw Material' ? 'selected' : '' }}>Raw
                                                Material
                                                (Bahan Baku)</option>
                                            <option value="Semi Finished Goods"
                                                {{ $itemsDataById->category == 'Semi Finished Goods' ? 'selected' : '' }}>
                                                Semi
                                                Finished Goods (Barang Setengah Jadi)</option>
                                            <option value="Finished Goods"
                                                {{ $itemsDataById->category == 'Finished Goods' ? 'selected' : '' }}>
                                                Finished Goods
                                                (Barang Jadi)</option>
                                            <option value="Consumable Supplies"
                                                {{ $itemsDataById->category == 'Consumable Supplies' ? 'selected' : '' }}>
                                                Consumable
                                                Supplies (Habis Pakai)</option>
                                            <option value="Tools & Equipment"
                                                {{ $itemsDataById->category == 'Tools & Equipment' ? 'selected' : '' }}>
                                                Tools &
                                                Equipment (Alat Produksi / Maintenance)</option>
                                            <option value="Spare Parts"
                                                {{ $itemsDataById->category == 'Spare Parts' ? 'selected' : '' }}>Spare
                                                Parts (Suku
                                                Cadang)</option>
                                            <option value="Packaging Material"
                                                {{ $itemsDataById->category == 'Packaging Material' ? 'selected' : '' }}>
                                                Packaging
                                                Material (Bahan Kemasan)</option>
                                            <option value="Safety Equipment"
                                                {{ $itemsDataById->category == 'Safety Equipment' ? 'selected' : '' }}>
                                                Safety
                                                Equipment (APD)</option>
                                            <option value="Office Supplies"
                                                {{ $itemsDataById->category == 'Office Supplies' ? 'selected' : '' }}>
                                                Office Supplies
                                                (ATK)</option>
                                            <option value="Miscellaneous"
                                                {{ $itemsDataById->category == 'Miscellaneous' ? 'selected' : '' }}>
                                                Miscellaneous
                                                (Lain-lain)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="status_item" class="form-label">Status Barang</label>
                                        <select name="status_item" id="status_item" class="form-select" required>
                                            <option value="" disabled>-- Pilih Kategori Barang --</option>
                                            <option value="Active"
                                                {{ $itemsDataById->status_item == 'Active' ? 'selected' : '' }}>Active
                                            </option>

                                            <option value="Non Active"
                                                {{ $itemsDataById->status_item == 'Non Active' ? 'selected' : '' }}>Non
                                                Active</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="branch_company_id" class="form-label">Cabang Perusahaan</label>
                                        <select name="branch_company_id" id="branch_company_id" class="form-select"
                                            required>
                                            <option value="" disabled>-- Pilih Cabang Perusahaan --</option>
                                            @foreach ($dataBranch as $branch)
                                            <option value="{{ $branch->id }}"
                                                {{ $itemsDataById->branch_company_id == $branch->id ? 'selected' : '' }}>
                                                {{ $branch->name_branch_company }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="col-md-6">
                                    <label>Minim Stok</label>
                                    <input type="number" name="minim_stok" id="minim_stok" class="form-control"
                                        placeholder="Cth: 100" min="1" value="{{$itemsDataById->minim_stok}}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="col-md-6">
                                    <label>Konversi Item</label>
                                    <input type="number" name="branch_company_id" id="branch_company_id" class="form-control"
                                        placeholder="Cth: 100" min="1" value="{{$itemsDataById->branch_company_id}}">
                                </div>
                            </div>

                              <div class="form-group mt-3">
                            <label>Deskripsi</label>
                            <textarea id="description" name="description" class="form-control" rows="2"
                                placeholder="Jelaskan description barang...">{{$itemsDataById->description}}</textarea>
                        </div>

                        </div>
                        <div class="modal-footer d-flex justify-content-end gap-2">
                            <a href="{{route('items.index')}}" class="btn btn-light-secondary">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Tutup</span>
                            </a>

                            <button type="submit" class="btn btn-primary ms-1">

                                <span class="d-none d-sm-block">Tambah Data</span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

{{-- Script JavaScript --}}
{{-- Script Preview Gambar Baru --}}
<script>
    function previewNewImage(event) {
        const file = event.target.files[0];
        const newPreviewContainer = document.getElementById('newLogoPreviewContainer');
        const newPreview = document.getElementById('newLogoPreview');

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                newPreview.src = e.target.result;
                newPreviewContainer.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            newPreviewContainer.style.display = 'none';
            newPreview.src = '';
        }
    }

</script>
@endsection
