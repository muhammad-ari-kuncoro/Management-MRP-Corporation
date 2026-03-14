@extends('layouts.layouts_dashboard')
@section('row')

@section('page-content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Form Tambah Barang Baru</h4>
                </div>

                <div class="card-body">
                    <form id="barangForm" action="" method="POST">
                        @csrf

                        <div class="form-group mb-3">
                            <label>Kode Product</label>
                            <input type="text" name="product_code" id="product_code" class="form-control"
                                placeholder="Cth: BRG-001">
                        </div>

                        <div class="form-group mb-3">
                            <label>Nama Barang</label>
                            <input type="text" name="product_name" id="product_name" class="form-control"
                                placeholder="Masukkan nama barang">
                        </div>

                        <div class="form-group mb-3">
                            <label>Spesifikasi Barang</label>
                            <input type="text" name="spesification_product" id="spesification_product"
                                class="form-control" placeholder="Masukkan Spesifikasi barang">
                        </div>

                        <div class="form-group mb-3">
                            <label>Tipe Barang</label>
                            <input type="text" name="type" id="type" class="form-control"
                                placeholder="Cth: Elektronik, Kimia, dll">
                        </div>

                        <div class="form-group mb-3">
                            <label>Satuan</label>
                            <select name="unit" id="unit" class="form-select">
                                <option value="">-- Pilih Satuan --</option>
                                <option value="Pcs">Pcs</option>
                                <option value="Lusin">Lusin</option>
                                <option value="Kg">Kg</option>
                                <option value="Gram">Gram</option>
                            </select>
                        </div>

                        {{-- Menggunakan onInput & onKeyDown untuk Mencegah Inoutan Character dan Simbol sejenisnya --}}
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Jumlah Product(Qty)</label>
                            <input type="number" name="qty_product" id="qty_product" class="form-control"
                                placeholder="Masukkan jumlah Quantity Produk" min="0"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                onkeydown="return event.keyCode !== 189 && event.keyCode !== 187 && event.keyCode !== 107 && event.keyCode !== 109;">
                            <small class="text-muted">Hanya angka (0 - 9), tidak bisa input huruf atau simbol</small>
                            @error('qty_product')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label>Tipe Kuantitas</label>
                            <select name="type_qty" id="type_qty" class="form-select">
                                <option value="">-- Pilih Tipe Kuantitas --</option>
                                <option value="In">Masuk</option>
                                <option value="Out">Keluar</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label>Status Barang</label>
                            <select name="status" id="status" class="form-select">
                                <option value="">-- Pilih Status --</option>
                                <option value="Active">Active</option>
                                <option value="Non Active">Non Active</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label>Deskripsi</label>
                            <textarea name="description_product" id="description_product" class="form-control"
                                placeholder="Jelaskan detail barang..." rows="2"></textarea>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="button" class="btn btn-primary" id="addToTable">
                                Tambah ke Tabel
                            </button>
                        </div>
                    </form>

                    <hr>

                    <h5>Daftar Barang</h5>
                    <table class="table table-bordered mt-3" id="barangTable">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Spesifikasi</th>
                                <th>Tipe</th>
                                <th>Satuan</th>
                                <th>Qty</th>
                                <th>Tipe Qty</th>
                                <th>Status</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                    <div class="d-flex justify-content-end">
                        <button type="submit" id="submitAll" class="btn btn-success">
                            Simpan ke Database
                        </button>
                        <a href="{{ route('product.index') }}" class="btn btn-danger">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let daftarBarang = [];

        const addBtn = document.getElementById('addToTable');
        const submitBtn = document.getElementById('submitAll');
        const barangForm = document.getElementById('barangForm');

        addBtn.addEventListener('click', function () {
            const barang = {
                product_code: document.getElementById('product_code').value.trim(),
                product_name: document.getElementById('product_name').value.trim(),
                spesification_product: document.getElementById('spesification_product').value
                .trim(),
                type: document.getElementById('type').value.trim(),
                unit: document.getElementById('unit').value,
                qty_product: document.getElementById('qty_product').value,
                type_qty: document.getElementById('type_qty').value,
                status: document.getElementById('status').value,
                description_product: document.getElementById('description_product').value.trim(),
            };

            if (!barang.product_code || !barang.product_name || !barang.spesification_product ||
                !barang.type || !barang.unit || !barang.qty_product || !barang.type_qty || !barang
                .status) {
                alert('Semua field wajib diisi!');
                return;
            }

            daftarBarang.push(barang);
            renderTable();
            barangForm.reset();
        });

        function renderTable() {
            const tbody = document.querySelector('#barangTable tbody');
            tbody.innerHTML = '';

            daftarBarang.forEach((b, i) => {
                const row = `
                <tr>
                    <td>${b.product_code}</td>
                    <td>${b.product_name}</td>
                    <td>${b.spesification_product}</td>
                    <td>${b.type}</td>
                    <td>${b.unit}</td>
                    <td>${b.qty_product}</td>
                    <td>${b.type_qty}</td>
                    <td>${b.status}</td>
                    <td>${b.description_product}</td>
                    <td><button class="btn btn-danger btn-sm" onclick="hapusBarang(${i})">Hapus</button></td>
                </tr>
            `;
                tbody.insertAdjacentHTML('beforeend', row);
            });
        }

        window.hapusBarang = function (index) {
            daftarBarang.splice(index, 1);
            renderTable();
        };

        submitBtn.addEventListener('click', async function () {
            if (daftarBarang.length === 0) {
                alert('Tabel masih kosong!');
                return;
            }

            const csrfToken = document.querySelector('input[name="_token"]').value;

            try {
                const res = await fetch("{{ route('product.store') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({
                        data: daftarBarang
                    })
                });

                const data = await res.json();
                alert(data.message || 'Data berhasil disimpan!');
                daftarBarang = [];
                renderTable();
            } catch (err) {
                console.error(err);
                alert('Terjadi kesalahan saat menyimpan data.');
            }
        });
    });

</script>

@endsection
