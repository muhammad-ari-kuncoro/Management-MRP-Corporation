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
                        <h4 class="mb-0 me-4">Data Master Cabang Perusahaan</h4>

                        <!-- Button trigger for login form modal -->
                        <button type="button" class="btn btn-primary icon icon-left" data-bs-toggle="modal"
                        data-bs-target="#inlineForm"> <i class="bi bi-plus-circle-fill"></i>
                        Tambah Data Cabang Perusahaan
                    </button>
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
                                <th>No</th>
                                <th>Nama Cabang Perusahaan</th>
                                <th>Alamat Cabang Perusahaan</th>
                                <th>Email Cabang Perusahaan</th>
                                <th>Logo</th>
                                <th>Status</th>
                                <th>Phone Number</th>
                                <th style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>PT Contoh Jaya Mandiri</td>
                                <td>Jl. Merdeka No. 123, Jakarta</td>
                                <td>cabang@contoh.co.id</td>
                                <td>
                                    <img src="{{ asset('storage/logo_cabang/logo1.png') }}"
                                         alt="Logo Cabang"
                                         style="width: 50px; height: 50px; object-fit: contain;">
                                </td>
                                <td>Aktif</td>
                                <td>08123456789</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <!-- Tombol Edit -->
                                        <a href="#" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <!-- Tombol Hapus -->
                                        <form action="#" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
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
 <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog"
 aria-labelledby="myModalLabel33" aria-hidden="true">
 <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
     role="document">
     <div class="modal-content">
         <div class="modal-header">
             <h4 class="modal-title" id="myModalLabel33">Cabang Perusahaan Form</h4>
             <button type="button" class="close" data-bs-dismiss="modal"
                 aria-label="Close">
                 <i data-feather="x"></i>
             </button>
         </div>
         <form action="#" method="POST">
            <div class="modal-body">
                <div class="mb-3">
                    <label for="name_branch_company" class="form-label fw-semibold">Nama Cabang Perusahaan</label>
                    <input id="name_branch_company" type="name_branch_company" name="name_branch_company" class="form-control" placeholder="Masukkan Nama cabang Perusahaan" required>
                </div>

                <div class="mb-3">
                    <label for="text" class="form-label fw-semibold">Email Cabang Perusahaan</label>
                    <input id="address_branch_company" type="text" name="address_branch_company" class="form-control" placeholder="Masukkan Alamat cabang Perusahaan" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email Cabang Perusahaan</label>
                    <input id="email" type="email" name="email" class="form-control" placeholder="Masukkan email cabang" required>
                </div>

                <div class="mb-3">
                    <label for="logo" class="form-label fw-semibold">Logo Cabang Perusahaan</label>
                    <input id="logo" type="file" name="logo" class="form-control" accept="image/*">
                    <small class="text-muted">Format: JPG, PNG, maksimal 2MB</small>
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
