@extends('layouts.layouts_dashboard')
@section('row')

<div class="col-12">
    <div class="page-heading">
        <h3>Form Tambah Barang Baru</h3>
    </div>

    {{-- CARD 1: Identitas Barang --}}
    <div class="card mb-4">
        <div class="card-header">
            <h4><i class="bi bi-box-seam me-2"></i>Identitas Barang</h4>
        </div>
        <div class="card-body">
            <form id="barangForm">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="kd_item" class="form-label">Kode Barang <span class="text-danger">*</span></label>
                            <input type="text" name="kd_item" id="kd_item"
                                class="form-control" placeholder="Cth: BRG-001">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name_item" class="form-label">Nama Barang <span class="text-danger">*</span></label>
                            <input type="text" name="name_item" id="name_item"
                                class="form-control" placeholder="Masukkan nama barang">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="spesification" class="form-label">Spesifikasi Barang <span class="text-danger">*</span></label>
                            <input type="text" name="spesification" id="spesification"
                                class="form-control" placeholder="Masukkan spesifikasi barang">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="type" class="form-label">Tipe Barang <span class="text-danger">*</span></label>
                            <select name="type" id="type" class="form-select" required>
                                <option value="">-- Pilih Tipe Barang --</option>
                                <option value="Pcs">Pcs</option>
                                <option value="Lusin">Lusin</option>
                                <option value="Kg">Kilogram</option>
                                <option value="Gram">Gram</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="category" class="form-label">Kategori Barang <span class="text-danger">*</span></label>
                            <select name="category" id="category" class="form-select" required>
                                <option value="" disabled selected>-- Pilih Kategori Barang --</option>
                                <option value="Raw Material">Raw Material (Bahan Baku)</option>
                                <option value="Semi Finished Goods">Semi Finished Goods (Barang Setengah Jadi)</option>
                                <option value="Finished Goods">Finished Goods (Barang Jadi)</option>
                                <option value="Consumable Supplies">Consumable Supplies (Habis Pakai)</option>
                                <option value="Tools & Equipment">Tools & Equipment (Alat Produksi / Maintenance)</option>
                                <option value="Spare Parts">Spare Parts (Suku Cadang)</option>
                                <option value="Packaging Material">Packaging Material (Bahan Kemasan)</option>
                                <option value="Safety Equipment">Safety Equipment (APD)</option>
                                <option value="Office Supplies">Office Supplies (ATK)</option>
                                <option value="Miscellaneous">Miscellaneous (Lain-lain)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status_item" class="form-label">Status Barang <span class="text-danger">*</span></label>
                            <select name="status_item" id="status_item" class="form-select" required>
                                <option value="">-- Pilih Status Barang --</option>
                                <option value="Active">Active</option>
                                <option value="Non Active">Non Active</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="branch_company_id" class="form-label">Cabang Supplier <span class="text-danger">*</span></label>
                            <select name="branch_company_id" id="branch_company_id"
                                class="form-select @error('branch_company_id') is-invalid @enderror" required>
                                <option value="" disabled selected>-- Pilih Cabang Supplier --</option>
                                @foreach ($branch_company as $data)
                                    <option value="{{ $data->id }}">
                                        {{ $data->name_branch_company }} | Status: {{ $data->status }}
                                    </option>
                                @endforeach
                            </select>
                            @error('branch_company_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea id="description" name="description"
                                class="form-control" rows="3"
                                placeholder="Jelaskan deskripsi barang..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- CARD 2: Harga & Stok --}}
    <div class="card mb-4">
        <div class="card-header">
            <h4><i class="bi bi-currency-dollar me-2"></i>Harga & Stok</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="price_item" class="form-label">Harga Jual (Rp) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="price_item" id="price_item"
                                class="form-control" placeholder="Cth: 150000" min="1">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="hpp" class="form-label">HPP (%) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" name="hpp" id="hpp"
                                class="form-control" placeholder="Masukkan persentase HPP"
                                min="0" max="100" step="0.01" required>
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="qty" class="form-label">Stok Awal <span class="text-danger">*</span></label>
                        <input type="number" name="qty" id="qty"
                            class="form-control" placeholder="Cth: 100" min="1">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="minim_stok" class="form-label">Minimum Stok <span class="text-danger">*</span></label>
                        <input type="number" name="minim_stok" id="minim_stok"
                            class="form-control" placeholder="Cth: 10" min="1">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="weight_item" class="form-label">Berat Barang (Kg) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" name="weight_item" id="weight_item"
                                class="form-control" placeholder="Cth: 5" min="1">
                            <span class="input-group-text">Kg</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="konversion_items_carbon" class="form-label">Konversi Karbon <span class="text-danger">*</span></label>
                        <input type="number" name="konversion_items_carbon" id="konversion_items_carbon"
                            class="form-control" placeholder="Cth: 100" min="1">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tombol Tambah ke Tabel --}}
    <div class="d-flex justify-content-end mb-4">
        <button type="button" class="btn btn-primary" id="addToTable">
            <i class="bi bi-plus-circle me-1"></i> Tambah ke Tabel
        </button>
    </div>

    </form>{{-- tutup form di sini --}}

    {{-- CARD 3: Preview Tabel --}}
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="bi bi-table me-2"></i>Daftar Barang</h4>
            <span class="badge bg-primary" id="jumlahBarang">0 item</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="barangTable">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Barang</th>
                            <th>Spesifikasi</th>
                            <th>Tipe</th>
                            <th>Harga Jual</th>
                            <th>Stok</th>
                            <th>HPP</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Cabang</th>
                            <th>Min. Stok</th>
                            <th>Konversi</th>
                            <th>Berat</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="emptyRow">
                            <td colspan="15" class="text-center text-muted py-4">
                                <i class="bi bi-inbox me-2"></i>Belum ada barang ditambahkan
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Tombol Simpan --}}
    <div class="d-flex justify-content-end gap-2 mb-5">
        <a href="{{ route('items.index') }}" class="btn btn-secondary">
            <i class="bi bi-x-circle me-1"></i> Kembali
        </a>
        <button type="button" id="submitAll" class="btn btn-success">
            <i class="bi bi-check-circle me-1"></i> Simpan ke Database
        </button>
    </div>

</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let daftarBarang = [];

        const addBtn    = document.getElementById('addToTable');
        const submitBtn = document.getElementById('submitAll');
        const barangForm = document.getElementById('barangForm');

        if (!addBtn || !submitBtn || !barangForm) {
            console.error('Element tidak ditemukan.');
            return;
        }

        addBtn.addEventListener('click', function () {
            const kode                    = document.getElementById('kd_item').value.trim();
            const nama                    = document.getElementById('name_item').value.trim();
            const spesification           = document.getElementById('spesification').value.trim();
            const type                    = document.getElementById('type').value;
            const price_item              = document.getElementById('price_item').value;
            const qty                     = document.getElementById('qty').value;
            const hpp                     = document.getElementById('hpp').value;
            const category                = document.getElementById('category').value;
            const status_item             = document.getElementById('status_item').value;
            const branchSelect            = document.getElementById('branch_company_id');
            const branch_company_id       = branchSelect ? branchSelect.value : '';
            const branch_company_name     = branchSelect ? branchSelect.options[branchSelect.selectedIndex].text : '';
            const minim_stok              = document.getElementById('minim_stok').value;
            const konversion_items_carbon = document.getElementById('konversion_items_carbon').value;
            const weight_item             = document.getElementById('weight_item').value;
            const description             = document.getElementById('description').value.trim();

            if (!kode || !nama || !spesification || !type || !price_item || !qty ||
                !hpp || !category || !status_item || !branch_company_id ||
                !minim_stok || !konversion_items_carbon || !weight_item || !description) {
                alert('Semua field wajib diisi!');
                return;
            }

            daftarBarang.push({
                kode, nama, spesification, type, price_item, qty, hpp,
                category, status_item, branch_company_id, branch_company_name,
                minim_stok, konversion_items_carbon, weight_item, description
            });

            renderTable();
            barangForm.reset();
        });

        function renderTable() {
            const tbody = document.querySelector('#barangTable tbody');
            const badge = document.getElementById('jumlahBarang');
            badge.textContent = daftarBarang.length + ' item';

            if (daftarBarang.length === 0) {
                tbody.innerHTML = `
                    <tr id="emptyRow">
                        <td colspan="15" class="text-center text-muted py-4">
                            <i class="bi bi-inbox me-2"></i>Belum ada barang ditambahkan
                        </td>
                    </tr>`;
                return;
            }

            tbody.innerHTML = '';
            daftarBarang.forEach((b, index) => {
                tbody.insertAdjacentHTML('beforeend', `
                    <tr>
                        <td>${escapeHtml(b.kode)}</td>
                        <td>${escapeHtml(b.nama)}</td>
                        <td>${escapeHtml(b.spesification)}</td>
                        <td>${escapeHtml(b.type)}</td>
                        <td>Rp ${Number(b.price_item).toLocaleString('id-ID')}</td>
                        <td>${escapeHtml(b.qty)}</td>
                        <td>${escapeHtml(b.hpp)}%</td>
                        <td>${escapeHtml(b.category)}</td>
                        <td>
                            <span class="badge ${b.status_item === 'Active' ? 'bg-success' : 'bg-secondary'}">
                                ${escapeHtml(b.status_item)}
                            </span>
                        </td>
                        <td>${escapeHtml(b.branch_company_name)}</td>
                        <td>${escapeHtml(b.minim_stok)}</td>
                        <td>${escapeHtml(b.konversion_items_carbon)}</td>
                        <td>${escapeHtml(b.weight_item)} Kg</td>
                        <td>${escapeHtml(b.description)}</td>
                        <td>
                            <button class="btn btn-danger btn-sm" onclick="hapusBarang(${index})">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>`);
            });
        }

        window.hapusBarang = function(index) {
            daftarBarang.splice(index, 1);
            renderTable();
        }

        function escapeHtml(text) {
            if (text === null || text === undefined) return '';
            return String(text)
                .replace(/&/g, '&amp;')
                .replace(/"/g, '&quot;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;');
        }

        submitBtn.addEventListener('click', async function () {
            if (daftarBarang.length === 0) {
                alert('Tabel masih kosong!');
                return;
            }

            const tokenInput = document.querySelector('input[name="_token"]');
            const csrfToken  = tokenInput ? tokenInput.value : null;
            if (!csrfToken) {
                alert('CSRF token tidak ditemukan. Refresh halaman dan coba lagi.');
                return;
            }

            submitBtn.disabled  = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

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
                    let msg = 'Terjadi kesalahan saat menyimpan.';
                    try {
                        const json = JSON.parse(text);
                        if (json.message) msg = json.message;
                    } catch(e) {}
                    alert(msg);
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
                submitBtn.disabled  = false;
                submitBtn.innerHTML = '<i class="bi bi-check-circle me-1"></i> Simpan ke Database';
            }
        });
    });
</script>
@endpush
