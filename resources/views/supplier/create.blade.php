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
                    <form action="{{ route('supplier-company.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            {{-- Kolom Kiri --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name_suppliers" class="form-label">Nama Supplier</label>
                                    <input type="text"
                                        class="form-control @error('name_suppliers') is-invalid @enderror"
                                        id="name_suppliers" name="name_suppliers" value="{{ old('name_suppliers') }}"
                                        placeholder="Harap di isi Nama Supplier" required>
                                    @error('name_suppliers')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <label for="phone_number" class="form-label">No Telpon Supplier</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">+62</span>
                                    <input type="number"
                                        class="form-control @error('phone_number') is-invalid @enderror"
                                        id="phone_number" name="phone_number"
                                        placeholder="Harap Di isi No Telpon CTH : 8123455" required
                                        onkeydown="return event.keyCode !== 69 && event.keyCode !== 189 && event.keyCode !== 187"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">

                                    {{-- Menggunakan fungsi menonaktifkan Angka ^^^ --}}
                                    @error('phone_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="nickname_suppliers" class="form-label">Nickname Suppliers / Nama
                                        Panggilan</label>
                                    <input type="text"
                                        class="form-control @error('nickname_suppliers') is-invalid @enderror"
                                        id="nickname_suppliers" name="nickname_suppliers"
                                        value="{{ old('nickname_suppliers') }}"
                                        placeholder="Harap Di isi Nickname Supplier">
                                    @error('nickname_suppliers')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="type_suppliers" class="form-label">Type Supplier</label>
                                        <select name="type_suppliers" id="type_suppliers" name="type_suppliers"
                                            class="form-select" required>
                                            <option value="" disabled>-- Pilih Cabang barang --</option>
                                            <option value="Manufaktur">Manufaktur</option>
                                            <option value="Kuliner">Kuliner</option>
                                            <option value="Garment">Garment</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Supplier</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email') }}" required
                                        placeholder="Harap Di isi Email Supplier">
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="brand" class="form-label">Brand Produk Supplier</label>
                                    <input type="brand" class="form-control @error('brand') is-invalid @enderror"
                                        id="brand" name="brand" value="{{ old('brand') }}" required
                                        placeholder="Harap Di isi Brand Supplier">
                                    @error('brand')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="address" class="form-label">Alamat Supplier</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" id="address"
                                        name="address" rows="3" placeholder="Harap Di isi Alamat Supplier"></textarea>
                                    @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="address_shipping" class="form-label">Alamat Pengiriman</label>
                                    <textarea class="form-control @error('address_shipping') is-invalid @enderror"
                                        id="address_shipping" name="address_shipping" rows="3"
                                        placeholder="Harap Di isi Alamat Pengiriman" required></textarea>
                                    @error('address_shipping')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="name_pic" class="form-label">Nama PIC</label>
                                    <input type="text" class="form-control @error('name_pic') is-invalid @enderror"
                                        id="name_pic" name="name_pic" value="{{ old('name_pic') }}"
                                        placeholder="Harap Di Isi Nama PIC / (Penanggung Jawab)" required>
                                    @error('name_pic')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <label for="phone_number_pic" class="form-label">No Telpon PIC</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">+62</span>
                                    <input type="number"
                                        class="form-control @error('phone_number_pic') is-invalid @enderror"
                                        id="phone_number_pic" name="phone_number_pic"
                                        placeholder="Harap Di isi No Telpon PIC / (Penanggung Jawab) CTH : 8123455"
                                        required
                                        onkeydown="return event.keyCode !== 69 && event.keyCode !== 189 && event.keyCode !== 187"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">

                                    {{-- Menggunakan fungsi menonaktifkan Angka ^^^ --}}
                                    @error('phone_number_pic')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- <div class="mb-3">
                                            <label for="position_pic" class="form-label">Posisi PIC</label>
                                            <input type="number"
                                                class="form-control @error('position_pic') is-invalid @enderror"
                                                id="position_pic" name="position_pic"  placeholder="Opsional">
                                            @error('position_pic')
                                            <div class="invalid-feedback">{{ $message }}
                                        </div>
                                        @enderror
                                    </div> --}}
                        <div class="mb-3">
                            <label for="npwp" class="form-label">NPWP</label>
                            <input type="number" class="form-control @error('npwp') is-invalid @enderror" id="npwp"
                                name="npwp" value="{{ old('npwp') ?? 0 }}" min="0" placeholder="Harap Di Isi NPWP"
                                required>
                            @error('npwp')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="scan_npwp" class="form-label">Upload Scan NPWP</label>
                            <input type="file" class="form-control @error('scan_npwp') is-invalid @enderror"
                                id="scan_npwp" name="scan_npwp" accept="image/*,application/pdf"
                                onchange="previewNPWP(event)">
                            @error('scan_npwp')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            {{-- Preview NPWP --}}
                            <div class="mt-3" id="preview-container-npwp" style="display:none;">
                                <p class="mb-1 fw-bold">Preview:</p>
                                <img id="preview-image-npwp" src="#" alt="Preview SIUP"
                                    style="max-width: 300px; border: 1px solid #ccc; border-radius: 5px;">
                                <iframe id="preview-pdf-npwp"
                                    style="width: 100%; height: 400px; border: 1px solid #ccc; display:none;"></iframe>
                            </div>
                        </div>
                </div>

                {{-- Kolom Kanan --}}
                <div class="col-md-6">

                    <div class="mb-3">
                        <label for="website" class="form-label">Website Supplier</label>
                        <input type="text" class="form-control @error('website') is-invalid @enderror" id="website"
                            name="website" placeholder="Harap Di isi Nama Website Supplier" required>
                        @error('website')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="no_rek" class="form-label">No Rekening Pembayaran</label>
                        <input type="number" class="form-control @error('no_rek') is-invalid @enderror" id="no_rek"
                            name="no_rek" value="{{ old('no_rek') ?? 0 }}"
                            placeholder="Harap Di isi No Rekening Supplier" required min="1">
                        @error('no_rek')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <label for="top" class="form-label">Jatoh Tempo</label>
                    <div class="input-group mb-3">

                        <input type="number" class="form-control @error('top') is-invalid @enderror" id="top" name="top"
                            placeholder="Harap Di isi No Telpon CTH : 30 " required
                            onkeydown="return event.keyCode !== 69 && event.keyCode !== 189 && event.keyCode !== 187"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')" max="30"><span
                            class="input-group-text">Hari</span>

                        {{-- Menggunakan fungsi menonaktifkan Angka ^^^ --}}
                        @error('top')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="limit_kredit" class="form-label">Limit Pembayaran Kredit</label>
                        <input type="number" class="form-control @error('limit_kredit') is-invalid @enderror"
                            id="limit_kredit" name="limit_kredit" value="{{ old('limit_kredit') ?? 0 }}" required
                            onkeydown="return event.keyCode !== 69 && event.keyCode !== 189 && event.keyCode !== 187"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        @error('limit_kredit')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="sales" class="form-label">Nama Sales</label>
                        <input type="text" class="form-control @error('sales') is-invalid @enderror" id="sales"
                            name="sales" value="{{ old('sales') }}" placeholder="Harap Di Isi Nama Sales" required>
                        @error('sales')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="method_payment" class="form-label">Metode Pembayaran</label>
                        <input type="text" class="form-control @error('method_payment') is-invalid @enderror"
                            id="method_payment" name="method_payment" value="{{ old('method_payment') }}"
                            placeholder="Harap Di Isi" required>
                        @error('method_payment')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="duration_shipping" class="form-label">Durasi Pengiriman</label>
                        <input type="text" class="form-control @error('duration_shipping') is-invalid @enderror"
                            id="duration_shipping" name="duration_shipping" value="{{ old('duration_shipping') }}"
                            min="0" placeholder="Harap Di Isi Paling Lambat Pengiriman" required>
                        @error('duration_shipping')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="id_region" class="form-label">ID Region</label>
                        <input type="number" class="form-control @error('id_region') is-invalid @enderror"
                            id="id_region" name="id_region" value="{{ old('no_rek') ?? 0 }}" min="0" required>
                        @error('id_region')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="branch_company_id" class="form-label">Pilih Cabang</label>
                            <select name="branch_company_id" id="branch_company_id" name="branch_company_id"
                                class="form-select" required>
                                <option value="" disabled selected>-- Pilih Cabang barang --</option>
                                @foreach ($branchCompany as $data)
                                <option value="{{$data->id}}">{{$data->name_branch_company}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="bank" class="form-label">Nama Bank Supplier</label>
                        <input type="text" class="form-control @error('bank') is-invalid @enderror" id="bank"
                            name="bank" required>
                        @error('bank')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="siup" class="form-label">SIUP</label>
                        <input type="text" class="form-control @error('siup') is-invalid @enderror" id="siup"
                            name="siup" value="{{ old('siup') ?? 0 }}" placeholder="Harap Di isi No SIUP " required>
                        @error('siup')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="scan_siup" class="form-label">Upload Scan SIUP</label>
                        <input type="file" class="form-control @error('scan_siup') is-invalid @enderror" id="scan_siup"
                            name="scan_siup" accept="image/*,application/pdf" onchange="previewSIUP(event)">
                        @error('scan_siup')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror


                        <div class="mt-3" id="preview-container-siup" style="display:none;">
                            <p class="mb-1 fw-bold">Preview:</p>
                            <img id="preview-image-siup" src="#" alt="Preview SIUP"
                                style="max-width: 300px; border: 1px solid #ccc; border-radius: 5px;">
                            <iframe id="preview-pdf-siup"
                                style="width: 100%; height: 400px; border: 1px solid #ccc; display:none;"></iframe>
                        </div>
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
    // FOR NUMBER PHONE PIC
    // FUNCTION MEMBLOKIR INPUTAN  SEPERTI - , + YANG SECARA JIKA MENGGUNAKAN NUMBER ITU SUDAH KEBAWA SEPERTI - + DSB
    document.addEventListener('DOMContentLoaded', function () {
        const inputField = document.getElementById('phone_number_pic');
        // Metode kedua: Mencegah input karakter E (kode 69), minus (kode 189), dan plus (kode 187) saat tombol ditekan
        inputField.addEventListener('keydown', function (event) {
            // Mencegah 'e'/'E', '-'
            if (event.key === 'e' || event.key === 'E' || event.key === '-' || event.key === '+') {
                event.preventDefault();
            }
        });
        // Metode ketiga: Membersihkan input setelah diketik/paste
        inputField.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });
    // ----------- -------------------------------END FUNCTION ------------------------------------------\\

    // ------------------------------- FUNCTION FOR NUMBER PHONE SUPPLIER ---------------------------- \\

    document.addEventListener('DOMContentLoaded', function () {
        const inputField = document.getElementById('phone_number');
        // Metode kedua: Mencegah input karakter E (kode 69), minus (kode 189), dan plus (kode 187) saat tombol ditekan
        inputField.addEventListener('keydown', function (event) {
            // Mencegah 'e'/'E', '-'
            if (event.key === 'e' || event.key === 'E' || event.key === '-' || event.key === '+') {
                event.preventDefault();
            }
        });
        // Metode ketiga: Membersihkan input setelah diketik/paste
        inputField.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });

    // ------------------------------------- END FUNCTION PHONE NUMBER --------------------------------\\
    document.addEventListener('DOMContentLoaded', function () {
        const inputField = document.getElementById('top');
        // Metode kedua: Mencegah input karakter E (kode 69), minus (kode 189), dan plus (kode 187) saat tombol ditekan
        inputField.addEventListener('keydown', function (event) {
            // Mencegah 'e'/'E', '-'
            if (event.key === 'e' || event.key === 'E' || event.key === '-' || event.key === '+') {
                event.preventDefault();
            }
        });
        // Metode ketiga: Membersihkan input setelah diketik/paste
        inputField.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });
    // --------------------------------------- FUNCTION TOP -------------------------------------------\\

    // ------------------------------------- END FUNCTION PHONE NUMBER --------------------------------\\
    document.addEventListener('DOMContentLoaded', function () {
        const inputField = document.getElementById('limit_kredit');
        // Metode kedua: Mencegah input karakter E (kode 69), minus (kode 189), dan plus (kode 187) saat tombol ditekan
        inputField.addEventListener('keydown', function (event) {
            // Mencegah 'e'/'E', '-'
            if (event.key === 'e' || event.key === 'E' || event.key === '-' || event.key === '+') {
                event.preventDefault();
            }
        });
        // Metode ketiga: Membersihkan input setelah diketik/paste
        inputField.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });
    // --------------------------------------- FUNCTION TOP -------------------------------------------\\


    // ------------------------------- FUNCTION NPWP -------------------------------------------------\\
    // Preview NPWP
    function previewNPWP(event) {
        const file = event.target.files[0];
        const previewContainer = document.getElementById('preview-container-npwp');
        const previewImage = document.getElementById('preview-image-npwp');
        const previewPDF = document.getElementById('preview-pdf-npwp');

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
    // ------------------------------------- END FUNCTION NPWP ----------------------------------------\\

    function previewSIUP(event) {
        const file = event.target.files[0];
        const previewContainer = document.getElementById('preview-container-siup');
        const previewImage = document.getElementById('preview-image-siup');
        const previewPDF = document.getElementById('preview-pdf-siup');

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
