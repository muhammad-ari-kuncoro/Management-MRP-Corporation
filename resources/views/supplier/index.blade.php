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
                        <h4 class="mb-0 me-4">Data Master Supplier Perusahaan</h4>

                        <!-- Button trigger for login form modal -->
                        <a href="{{route('supplier-company.create')}}" class="btn btn-primary icon icon-left"><i
                                class="bi bi-plus-circle-fill"></i>
                            Tambah Data Supplier</a>
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
                    <table class="table table-hover" id="myTable9">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Supplier</th>
                                <th>Type Supplier</th>
                                <th>Phone Number Supplier</th>
                                <th>Nama PIC</th>
                                <th>Email</th>
                                <th>TOP</th>
                                <th>Limit Kredit</th>
                                <th>Blacklist / Pemblokiran</th>
                                <th style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>No 1</td>
                                <td>TEST</td>
                                <td>TEST</td>
                                <td>TEST</td>
                                <td>TEST</td>
                                <td>TEST</td>
                                <td>TEST</td>
                                <td>TEST</td>
                                <td>
                                    TEST
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <!-- Tombol Edit -->
                                        <!-- Tombol Hapus -->
                                        <form action="#" method="POST"
                                            onsubmit="return confirm('Yakin hapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
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
</div>
</div>

<!--login form Modal -->
<div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Supplier Perusahaan Form</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form action="{{route('branch-company.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name_branch_company" class="form-label fw-semibold">Nama Supplier Perusahaan</label>
                        <input id="name_branch_company" type="name_branch_company" name="name_branch_company"
                            class="form-control" placeholder="Masukkan Nama Supplier Perusahaan" required>
                        @error('name_branch_company')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address_branch_company" class="form-label fw-semibold">Alamat Supplier
                            Perusahaan</label>

                        <textarea id="address_branch_company" name="address_branch_company" class="form-control"
                            rows="3" placeholder="Masukkan Alamat Supplier Perusahaan"
                            required>{{ old('address_branch_company') }}</textarea>

                        <small class="text-muted">Masukkan alamat lengkap termasuk jalan, kota, dan kode pos.</small>

                        @error('address_branch_company')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email_branch_company" class="form-label fw-semibold">Email Supplier
                            Perusahaan</label>
                        <input id="email_branch_company" type="email" name="email_branch_company" class="form-control"
                            placeholder="Masukkan email Supplier" required>

                        @error('email_branch_company')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="logo" class="form-label fw-semibold">Logo Supplier Perusahaan</label>
                        <input id="logo" type="file" name="logo" class="form-control" accept="image/*">
                        <small class="text-muted">Format: JPG, PNG, maksimal 2MB</small>
                        @error('logo')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="status" class="form-label fw-semibold">Status Supplier</label>
                        <select id="status" name="status" class="form-select" required>
                            <option value="" disabled selected>Pilih Status</option>
                            <option value="Active">Active</option>
                            <option value="Non Active">Non Active</option>
                        </select>
                        @error('status')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="phone_number" class="form-label fw-semibold">No Telepon Supplier Perusahaan</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">+62</span>
                            <input id="phone_number" type="text" name="phone_number" class="form-control"
                                placeholder="Masukkan No telp Supplier Perusahaan" required>
                        </div>
                        @error('phone_number')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>


                </div>
                <div class="modal-footer d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Tutup</span>
                    </button>

                    <button type="submit" class="btn btn-primary ms-1">

                        <span class="d-none d-sm-block">Tambah Data</span>
                    </button>
                </div>
            </form>

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
    $('#myTable9').DataTable();
});
</script>
@endpush

