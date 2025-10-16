@extends('layouts.layouts_dashboard')
@section('row')

@section('page-content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Form Tambah Data Supplier </h4>
                </div>

                <div class="card-body">
                    <form action="" method="POST">
                        @csrf
                        <div class="row">
                            {{-- Kolom Kiri --}}
                            <div class="col-md-6">

                                {{-- 1. Nama Supplier --}}
                                <div class="mb-3">
                                    <label for="name_suppliers" class="form-label">Nama Supplier</label>
                                    <input type="text"
                                        class="form-control @error('name_suppliers') is-invalid @enderror"
                                        id="name_suppliers" name="name_suppliers" value="{{ old('name_suppliers') }}"
                                        required>
                                    @error('name_suppliers')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- 2. Nickname / Nama Panggilan --}}
                                <div class="mb-3">
                                    <label for="nickname_suppliers" class="form-label">Nickname Suppliers / Nama
                                        Panggilan</label>
                                    <input type="text"
                                        class="form-control @error('nickname_suppliers') is-invalid @enderror"
                                        id="nickname_suppliers" name="nickname_suppliers"
                                        value="{{ old('nickname_suppliers') }}">
                                    @error('nickname_suppliers')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- 3. Type Suppliers --}}
                                <div class="mb-3">
                                    <label for="type_suppliers" class="form-label">Type Suppliers</label>
                                    <input type="text"
                                        class="form-control @error('type_suppliers') is-invalid @enderror"
                                        id="type_suppliers" name="type_suppliers" value="{{ old('type_suppliers') }}">
                                    @error('type_suppliers')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                {{-- 4. Email Suppliers --}}
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Supplier</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- 5. Alamat Supplier --}}
                                <div class="mb-3">
                                    <label for="address" class="form-label">Alamat Supplier</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" id="address"
                                        name="address" rows="3"></textarea>
                                    @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                {{-- 6. Alamat Pengiriman --}}
                                <div class="mb-3">
                                    <label for="address_shipping" class="form-label">Alamat Pengiriman</label>
                                    <textarea class="form-control @error('address_shipping') is-invalid @enderror"
                                        id="address_shipping" name="address_shipping" rows="3"></textarea>
                                    @error('address_shipping')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- 8.Nama PIC --}}
                                <div class="mb-3">
                                    <label for="name_pic" class="form-label">Nama PIC</label>
                                    <input type="text" class="form-control @error('name_pic') is-invalid @enderror"
                                        id="name_pic" name="name_pic" value="{{ old('name_pic') }}" required>
                                    @error('name_pic')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- 9. No Telpon PIC --}}
                                <div class="mb-3">
                                    <label for="phone_number_pic" class="form-label">No Telpon PIC</label>
                                    <input type="number"
                                        class="form-control @error('phone_number_pic') is-invalid @enderror"
                                        id="phone_number_pic" name="phone_number_pic"
                                        value="{{ old('phone_number_pic') }}" required>
                                    @error('phone_number_pic')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- 10. Posisi PIC --}}
                                <div class="mb-3">
                                    <label for="position_pic" class="form-label">Posisi PIC</label>
                                    <input type="number"
                                        class="form-control @error('position_pic') is-invalid @enderror"
                                        id="position_pic" name="position_pic" required placeholder="Opsional">
                                    @error('position_pic')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                {{-- 11. Id Region --}}
                                <div class="mb-3">
                                    <label for="id_region" class="form-label">ID Region</label>
                                    <input type="number" class="form-control @error('id_region') is-invalid @enderror"
                                        id="id_region" name="id_region" value="{{ old('id_region') }}" min="0" required>
                                    @error('id_region')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- 20. NPWP --}}
                                <div class="mb-3">
                                    <label for="NPWP" class="form-label">NPWP</label>
                                    <input type="numnber" class="form-control @error('npwp') is-invalid @enderror"
                                        id="npwp" name="npwp" required min="1">
                                    @error('npwp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Tempat Preview --}}
                                <div class="mt-3" id="preview-container" style="display:none;">
                                    <p class="mb-1 fw-bold">Preview:</p>
                                    <img id="preview-image" src="#" alt="Preview SIUP"
                                        style="max-width: 300px; border: 1px solid #ccc; border-radius: 5px;">
                                    <iframe id="preview-pdf"
                                        style="width: 100%; height: 400px; border: 1px solid #ccc; display:none;"></iframe>
                                </div>
                            </div>

                        </div>

                        {{-- Kolom Kanan --}}
                        <div class="col-md-6">
                            {{-- 7. Website Suppliers --}}
                            <div class="mb-3">
                                <label for="website" class="form-label">Website Supplier</label>
                                <input type="text" class="form-control @error('website') is-invalid @enderror"
                                    id="website" name="website" required>
                                @error('website')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- 12. Perjanjian Pembayaran --}}
                            <div class="mb-3">
                                <label for="stok_awal" class="form-label">Perjanjian Pembayaran</label>
                                <input type="text" class="form-control @error('stok_awal') is-invalid @enderror"
                                    id="stok_awal" name="stok_awal" value="{{ old('stok_awal') ?? 0 }}" min="0"
                                    required>
                                @error('stok_awal')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- 13. Perjanjian Pembayaran --}}
                            <div class="mb-3">
                                <label for="limit_kredit" class="form-label">Limit Pembayaran Kredit</label>
                                <input type="text" class="form-control @error('limit_kredit') is-invalid @enderror"
                                    id="limit_kredit" name="limit_kredit" value="{{ old('limit_kredit') ?? 0 }}" min="0"
                                    required>
                                @error('limit_kredit')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- 14. Sales --}}
                            <div class="mb-3">
                                <label for="sales" class="form-label">Sales</label>
                                <input type="text" class="form-control @error('sales') is-invalid @enderror" id="sales"
                                    name="sales" value="{{ old('sales') }}" min="0" required>
                                @error('sales')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- 15. Metode Pembayaran --}}
                            <div class="mb-3">
                                <label for="method_payment" class="form-label">Metode Pembayaran</label>
                                <input type="text" class="form-control @error('method_payment') is-invalid @enderror"
                                    id="method_payment" name="method_payment" value="{{ old('method_payment') }}"
                                    min="0" required>
                                @error('method_payment')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- 15. Durasi Pengiriman --}}
                            <div class="mb-3">
                                <label for="duration_shipping" class="form-label">Durasi Pengiriman</label>
                                <input type="text" class="form-control @error('duration_shipping') is-invalid @enderror"
                                    id="duration_shipping" name="duration_shipping"
                                    value="{{ old('duration_shipping') }}" min="0" required>
                                @error('duration_shipping')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- 15. Durasi Pengiriman --}}
                            <div class="mb-3">
                                <label for="method_shipping" class="form-label">Metode Pengiriman</label>
                                <input type="text" class="form-control @error('method_shipping') is-invalid @enderror"
                                    id="method_shipping" name="method_shipping" min="0" required>
                                @error('method_shipping')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- 18. Brand Supplier --}}
                            <div class="mb-3">
                                <label for="method_shipping" class="form-label">Brand Supplier</label>
                                <input type="text" class="form-control @error('method_shipping') is-invalid @enderror"
                                    id="method_shipping" name="method_shipping" required>
                                @error('method_shipping')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="category" class="form-label">Kategori Cabang</label>
                                    <select name="category" id="category" name="category" class="form-select" required>
                                        @foreach ($branchCompany as $data)

                                        <option value="" disabled>-- Pilih Cabang barang --</option>
                                        <option value="{{$data->id}}">{{$data->name_branch_company}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- 19. Nama Bank --}}
                            <div class="mb-3">
                                <label for="Nama Bank" class="form-label">Nama Bank</label>
                                <input type="text" class="form-control @error('Nama Bank') is-invalid @enderror"
                                    id="Nama Bank" name="Nama Bank" required>
                                @error('Nama Bank')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>



                            {{-- 21. SIUP --}}
                            <div class="mb-3">
                                <label for="SIUP" class="form-label">SIUP</label>
                                <input type="text" class="form-control @error('Nama Bank') is-invalid @enderror"
                                    id="Nama Bank" name="Nama Bank" required>
                                @error('Nama Bank')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- Upload Scan SIUP + Preview --}}
                            <div class="mb-3">
                                <label for="scan_siup" class="form-label">Upload Scan SIUP</label>
                                <input type="file" class="form-control @error('scan_siup') is-invalid @enderror"
                                    id="scan_siup" name="scan_siup" accept="image/*,application/pdf"
                                    onchange="previewSIUP(event)">
                                @error('scan_siup')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                {{-- Tempat Preview --}}
                                <div class="mt-3" id="preview-container" style="display:none;">
                                    <p class="mb-1 fw-bold">Preview:</p>
                                    <img id="preview-image" src="#" alt="Preview SIUP"
                                        style="max-width: 300px; border: 1px solid #ccc; border-radius: 5px;">
                                    <iframe id="preview-pdf"
                                        style="width: 100%; height: 400px; border: 1px solid #ccc; display:none;"></iframe>
                                </div>
                            </div>



                        </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="d-flex justify-content-end mt-4">
                    <a href="" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Barang</button>
                </div>
                </form>
                {{-- Form berakhir di sini --}}
            </div>
        </div>
    </div>
</div>
</div>
@endsection
<script>
function previewSIUP(event) {
    const file = event.target.files[0];
    const previewContainer = document.getElementById('preview-container');
    const previewImage = document.getElementById('preview-image');
    const previewPDF = document.getElementById('preview-pdf');

    if (file) {
        const fileURL = URL.createObjectURL(file);
        previewContainer.style.display = 'block';

        if (file.type.includes('pdf')) {
            previewImage.style.display = 'none';
            previewPDF.style.display = 'block';
            previewPDF.src = fileURL;
        } else if (file.type.includes('image')) {
            previewPDF.style.display = 'none';
            previewImage.style.display = 'block';
            previewImage.src = fileURL;
        } else {
            previewContainer.style.display = 'none';
        }
    } else {
        previewContainer.style.display = 'none';
    }
}
</script>
