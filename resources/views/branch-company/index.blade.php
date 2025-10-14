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
                            @foreach ($data_branch as $data)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$data->name_branch_company}}</td>
                                <td>{{$data->address_branch_company}}</td>
                                <td>
                                    {{$data->email_branch_company}}
                                </td>
                                <td>
                                    <img src="{{ asset($data->logo) }}" alt="Logo Cabang"
                                        style="width: 50px; height: 50px; object-fit: contain;">
                                </td>
                                <td>
                                    <span class="badge {{ $data->status == 'Active' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($data->status) }}
                                    </span>
                                </td>
                                <td> (+62{{$data->phone_number}})</td>
                                <td>

                                    <div class="d-flex gap-2">
                                        <a href="{{ route('branch-company.edit',$data->id) }}"
                                            class="btn btn-sm btn-warning">
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

<!--login form Modal -->
<div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Cabang Perusahaan Form</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form action="{{route('branch-company.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name_branch_company" class="form-label fw-semibold">Nama Cabang Perusahaan</label>
                        <input id="name_branch_company" type="name_branch_company" name="name_branch_company"
                            class="form-control" placeholder="Masukkan Nama cabang Perusahaan" required>
                        @error('name_branch_company')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address_branch_company" class="form-label fw-semibold">Alamat Cabang
                            Perusahaan</label>

                        <textarea id="address_branch_company" name="address_branch_company" class="form-control"
                            rows="3" placeholder="Masukkan Alamat Cabang Perusahaan"
                            required>{{ old('address_branch_company') }}</textarea>

                        <small class="text-muted">Masukkan alamat lengkap termasuk jalan, kota, dan kode pos.</small>

                        @error('address_branch_company')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email_branch_company" class="form-label fw-semibold">Email Cabang Perusahaan</label>
                        <input id="email_branch_company" type="email" name="email_branch_company" class="form-control"
                            placeholder="Masukkan email cabang" required>

                        @error('email_branch_company')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="logo" class="form-label fw-semibold">Logo Cabang Perusahaan</label>
                        <input id="logo" type="file" name="logo" class="form-control" accept="image/*">
                        <small class="text-muted">Format: JPG, PNG, maksimal 2MB</small>
                        @error('logo')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="status" class="form-label fw-semibold">Status Cabang</label>
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
                        <label for="phone_number" class="form-label fw-semibold">No Telepon Cabang Perusahaan</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">+62</span>
                            <input id="phone_number" type="text" name="phone_number" class="form-control"
                                placeholder="Masukkan No telp Cabang Perusahaan" required>
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
