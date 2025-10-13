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
                    <form id="barangForm" action="" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label>Kode Barang</label>
                            <input type="text" name="kd_item" id="kd_item" class="form-control"
                                placeholder="Cth: BRG-001">
                        </div>


                        <div class="form-group mb-3">
                            <label>Nama Barang</label>
                            <input type="text" name="name_item" id="name_item" class="form-control"
                                placeholder="Masukkan nama barang">
                        </div>
                        <div class="form-group mb-3">
                            <label>Spesification Barang</label>
                            <input type="text" name="spesification" id="spesification" class="form-control"
                                placeholder="Masukkan Spesifikasi barang">
                        </div>

                        <div class="form-group mb-3">
                            <label for="type">Type Barang</label>
                            <select name="type" id="type" class="form-select" required>
                                <option value="">-- Pilih Tipe Barang --</option>
                                <option value="Pcs">Pcs</option>
                                <option value="Lusin">Lusin</option>
                                <option value="Kg">Kilogram</option>
                                <option value="Gram">Gram</option>
                            </select>
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <label>Harga Jual (Rp)</label>
                                <input type="number" name="price_item" id="price_item" class="form-control"
                                    placeholder="Cth: 50000" min="number">
                            </div>
                            <div class="col-md-6">
                                <label>Stok Awal</label>
                                <input type="number" name="qty" id="qty" class="form-control" placeholder="Cth: 100" min="1">
                            </div>

                            <div class="col-md-6">
                                <label for="hpp" class="form-label">HPP (%)</label>
                                <div class="input-group">
                                    <input type="number" name="hpp" id="hpp" class="form-control"
                                        placeholder="Masukkan persentase HPP" min="0" max="100" step="0.01" required min="1">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="category" class="form-label">Kategori Barang</label>
                                    <select name="category" id="category" name="category" class="form-select" required>
                                        <option value="" disabled>-- Pilih Kategori Barang --</option>
                                        <option value="Raw Material">Raw Material (Bahan Baku)</option>
                                        <option value="Semi Finished Goods">Semi Finished Goods (Barang Setengah Jadi)
                                        </option>
                                        <option value="Finished Goods">Finished Goods (Barang Jadi)</option>
                                        <option value="Consumable Supplies">Consumable Supplies (Habis Pakai)</option>
                                        <option value="Tools & Equipment">Tools & Equipment (Alat Produksi /
                                            Maintenance)</option>
                                        <option value="Spare Parts">Spare Parts (Suku Cadang)</option>
                                        <option value="Packaging Material">Packaging Material (Bahan Kemasan)</option>
                                        <option value="Safety Equipment">Safety Equipment (APD)</option>
                                        <option value="Office Supplies">Office Supplies (ATK)</option>
                                        <option value="Miscellaneous">Miscellaneous (Lain-lain)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="status_item">Status Barang</label>
                                <select name="status_item" id="status_item" class="form-select" required>
                                    <option value="">-- Pilih Status Barang --</option>
                                    <option value="Active">Active</option>
                                    <option value="Non Active">Non Active</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="branch_company_id" class="form-label" name="branch_company_id">Cabang Supplier Barang</label>
                                <select class="form-select rounded-top @error('branch_company_id') is-invalid @enderror"
                                    name="branch_company_id" id="branch_company_id" required>
                                    <option selected disabled>Pilih Cabang Supplier</option>
                                    @foreach ($branch_company as $data )
                                    <option value="{{ $data->id }}">{{ $data->name_branch_company }}  |  Status: {{ $data->status }} </option>
                                    @error('branch_company_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label>Minim Stock</label>
                            <input type="number" name="minim_stok" id="minim_stok" class="form-control" placeholder="Cth: 100" min="1">
                        </div>

                        <div class="col-md-6">
                            <label>Konversion Items</label>
                            <input type="number" name="konversion_items_carbon" id="konversion_items_carbon" class="form-control" placeholder="Cth: 100" min="1">
                        </div>
                        <div class="col-md-6">
                            <label>Berat Items</label>
                            <input type="number" name="weight_item" id="weight_item" class="form-control" placeholder="Cth: 100" min="1">
                        </div>

                        <div class="form-group mt-3">
                            <label>Deskripsi</label>
                            <textarea id="description" name="description" class="form-control" rows="2"
                                placeholder="Jelaskan description barang..."></textarea>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="button" class="btn btn-primary" id="addToTable">
                                <i class="bi bi-plus-circle me-1"></i> Tambah ke Tabel
                            </button>
                        </div>
                    </form>

                    <hr>

                    {{-- Tabel preview barang --}}
                    <h5>Daftar Barang</h5>
                    <table class="table table-bordered mt-3" id="barangTable">
                        <thead>
                            <tr>
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
                            {{-- baris ditambahkan otomatis --}}
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-end">
                        <button type="submit" id="submitAll" class="btn btn-success">
                            <i class="bi bi-check-circle me-1"></i> Simpan ke Database
                        </button>
                        <a href="{{ route('items.index') }}" class="btn btn-danger"><i class="bi bi-check-circle me-1"></i>
                            Kembali</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

{{-- Script JavaScript --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let daftarBarang = [];

        const addBtn = document.getElementById('addToTable');
        const submitBtn = document.getElementById('submitAll');
        const barangForm = document.getElementById('barangForm');

        // safety: pastikan elemen ada
        if (!addBtn || !submitBtn || !barangForm) {
            console.error('Element addToTable / submitAll / barangForm tidak ditemukan.');
            return;
        }

        addBtn.addEventListener('click', function () {
            const kode = document.getElementById('kd_item').value.trim();
            const nama = document.getElementById('name_item').value.trim();
            const spesification = document.getElementById('spesification').value.trim();
            const type = document.getElementById('type').value;
            const price_item = document.getElementById('price_item').value;
            const qty = document.getElementById('qty').value;
            const hpp = document.getElementById('hpp').value;
            const category = document.getElementById('category').value;
            const status_item = document.getElementById('status_item').value;
            const branchSelect = document.getElementById('branch_company_id');
            const branch_company_id = branchSelect ? branchSelect.value : '';
            const branch_company_name = branchSelect ? branchSelect.options[branchSelect.selectedIndex].text : '';
            const minim_stok = document.getElementById('minim_stok').value;
            const konversion_items_carbon = document.getElementById('konversion_items_carbon').value;
            const weight_item = document.getElementById('weight_item').value;
            const description = document.getElementById('description').value.trim();

            if (!kode || !nama || !spesification || !type || !price_item || !qty || !hpp || !category || !status_item || !branch_company_id || !minim_stok || !konversion_items_carbon || !weight_item || !description) {
                alert('Semua field wajib diisi!');
                return;
            }

            const barang = {
                kode,
                nama,
                spesification,
                type,
                price_item,
                qty,
                hpp,
                category,
                status_item,
                branch_company_id,
                branch_company_name, // simpan nama supaya bisa tampil di tabel
                minim_stok,
                konversion_items_carbon,
                weight_item,
                description
            };

            daftarBarang.push(barang);
            renderTable();
            barangForm.reset();
        });

        function renderTable() {
            const tbody = document.querySelector('#barangTable tbody');
            tbody.innerHTML = '';

            daftarBarang.forEach((b, index) => {
                const row = `
                    <tr>
                        <td>${escapeHtml(b.kode)}</td>
                        <td>${escapeHtml(b.nama)}</td>
                        <td>${escapeHtml(b.spesification)}</td>
                        <td>${escapeHtml(b.type)}</td>
                        <td>${escapeHtml(b.price_item)}</td>
                        <td>${escapeHtml(b.qty)}</td>
                        <td>${escapeHtml(b.hpp)}</td>
                        <td>${escapeHtml(b.category)}</td>
                        <td>${escapeHtml(b.status_item)}</td>
                        <td>${escapeHtml(b.branch_company_name)}</td>
                        <td>${escapeHtml(b.minim_stok)}</td>
                        <td>${escapeHtml(b.konversion_items_carbon)}</td>
                        <td>${escapeHtml(b.weight_item)} Kg</td>
                        <td>${escapeHtml(b.description)}</td>
                        <td>
                            <button class="btn btn-danger btn-sm" onclick="hapusBarang(${index})">Hapus</button>
                        </td>
                    </tr>`;
                tbody.insertAdjacentHTML('beforeend', row);
            });
        }

        // make hapusBarang global so onclick in markup can call it
        window.hapusBarang = function(index) {
            daftarBarang.splice(index, 1);
            renderTable();
        }

        // helper untuk mencegah XSS sederhana
        function escapeHtml(text) {
            if (text === null || text === undefined) return '';
            return String(text)
                .replace(/&/g, '&amp;')
                .replace(/"/g, '&quot;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;');
        }

        // Submit semua data via AJAX
        submitBtn.addEventListener('click', async function () {
            if (daftarBarang.length === 0) {
                alert('Tabel masih kosong!');
                return;
            }

            // ambil CSRF token (pastikan adanya input _token di form)
            const tokenInput = document.querySelector('input[name="_token"]');
            const csrfToken = tokenInput ? tokenInput.value : null;
            if (!csrfToken) {
                alert('CSRF token tidak ditemukan. Refresh halaman dan coba lagi.');
                return;
            }

            // disable button agar tidak double submit
            submitBtn.disabled = true;
            submitBtn.innerText = 'Menyimpan...';

            try {
                const res = await fetch("{{ route('items.store') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({ data: daftarBarang })
                });

                if (!res.ok) {
                    const text = await res.text();
                    console.error('Server error:', res.status, text);
                    let msg = 'Terjadi kesalahan saat menyimpan. Periksa console (Network) atau response server.';
                    try {
                        const json = JSON.parse(text);
                        if (json.message) msg = json.message;
                    } catch(e) {}
                    alert(msg);
                    submitBtn.disabled = false;
                    submitBtn.innerText = 'Simpan ke Database';
                    return;
                }

                const data = await res.json();
                alert(data.message || 'Data berhasil disimpan!');
                daftarBarang = [];
                renderTable();
            } catch (err) {
                console.error(err);
                alert('Kesalahan jaringan/JS. Cek console.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerText = 'Simpan ke Database';
            }
        });
    });
    </script>

@endsection
