@extends('layouts.layouts_dashboard')
@section('row')

@section('page-content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- Card Header untuk Halaman Tambah Data -->
                <div class="card-header">
                    <h4>Form Tambah Barang Baru</h4>
                </div>

                <!-- Card Body berisi Form Input -->
                <div class="card-body">

                    {{-- Form input --}}
                    <form action="{{route('branch-company.update',$branchCompanyById->id)}}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name_branch_company" class="form-label fw-semibold">Nama Cabang
                                    Perusahaan</label>
                                <input id="name_branch_company" type="name_branch_company" name="name_branch_company"
                                    class="form-control" placeholder="Masukkan Nama cabang Perusahaan"
                                    value="{{$branchCompanyById->name_branch_company}}">
                                @error('name_branch_company')
                                <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="address_branch_company" class="form-label fw-semibold">Alamat Cabang
                                    Perusahaan</label>

                                <textarea id="address_branch_company" name="address_branch_company" class="form-control"
                                    rows="3" placeholder="Masukkan Alamat Cabang Perusahaan"
                                    required>{{$branchCompanyById->address_branch_company}}</textarea>

                                <small class="text-muted">Masukkan alamat lengkap termasuk jalan, kota, dan kode
                                    pos.</small>

                                @error('address_branch_company')
                                <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email_branch_company" class="form-label fw-semibold">Email Cabang
                                    Perusahaan</label>
                                <input id="email_branch_company" type="email" name="email_branch_company"
                                    class="form-control" placeholder="Masukkan email cabang"
                                    value="{{$branchCompanyById->email_branch_company}}" required>

                                @error('email_branch_company')
                                <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="logo" class="form-label fw-semibold">Logo Cabang Perusahaan</label>

                                @if($branchCompanyById->logo)
                                <div class="mb-2">
                                    <p class="mb-1 text-muted">Logo Lama:</p>
                                    <img src="{{ asset($branchCompanyById->logo) }}" alt="Logo Lama"
                                        class="rounded border" style="max-height: 120px;">
                                </div>
                                @endif

                                {{-- Preview gambar baru --}}
                                <div class="mb-2" id="newLogoPreviewContainer" style="display: none;">
                                    <p class="mb-1 text-muted">Logo baru:</p>
                                    <img id="newLogoPreview" class="rounded border" style="max-height: 120px;">
                                </div>

                                {{-- Input file --}}
                                <input id="logo" type="file" name="logo" class="form-control" accept="image/*"
                                    onchange="previewNewImage(event)">

                                <small class="text-muted">Format: JPG, PNG, maksimal 2MB</small>

                                @error('logo')
                                <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label fw-semibold">Status Cabang</label>
                                <select id="status" name="status" class="form-select" required>
                                    <option value="" disabled>Pilih Status</option>
                                    <option value="Active"
                                        {{ $branchCompanyById->status === 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Non Active"
                                        {{ $branchCompanyById->status === 'Non Active' ? 'selected' : '' }}>Non Active
                                    </option>
                                </select>
                                @error('status')
                                <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>



                            <div class="mb-3">
                                <label for="phone_number" class="form-label fw-semibold">No Telepon Cabang
                                    Perusahaan</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">+62</span>
                                    <input id="phone_number" type="text" name="phone_number" class="form-control"
                                        placeholder="Masukkan No telp Cabang Perusahaan" value="{{$branchCompanyById->phone_number}}" required>
                                </div>
                                @error('phone_number')
                                <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>


                        </div>
                        <div class="modal-footer d-flex justify-content-end gap-2">
                            <a href="{{route('branch-company.index')}}" class="btn btn-light-secondary">
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
