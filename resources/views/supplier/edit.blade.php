@extends('layouts.layouts_dashboard')
@section('row')
    <div class="col-12">
        <div class="page-heading">
            <h3>Form Edit Data Supplier</h3>
        </div>

        <form action="{{ route('supplier-company.update', $dataSupplierById->id) }}" method="POST"
            enctype="multipart/form-data">
            @method('PUT')
            @csrf

            {{-- CARD 1: Identitas Supplier --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h4><i class="bi bi-person-vcard me-2"></i>Identitas Supplier</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name_suppliers" class="form-label">Nama Supplier <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name_suppliers') is-invalid @enderror"
                                    id="name_suppliers" name="name_suppliers"
                                    value="{{ old('name_suppliers', $dataSupplierById->name_suppliers) }}"
                                    placeholder="Masukkan nama supplier" required>
                                @error('name_suppliers')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nickname_suppliers" class="form-label">Nickname / Nama Panggilan</label>
                                <input type="text" class="form-control @error('nickname_suppliers') is-invalid @enderror"
                                    id="nickname_suppliers" name="nickname_suppliers"
                                    value="{{ old('nickname_suppliers', $dataSupplierById->nickname_suppliers) }}"
                                    placeholder="Masukkan nickname supplier">
                                @error('nickname_suppliers')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="type_suppliers" class="form-label">Tipe Supplier <span
                                        class="text-danger">*</span></label>
                                <select name="type_suppliers" id="type_suppliers"
                                    class="form-select @error('type_suppliers') is-invalid @enderror" required>
                                    <option value="" disabled>-- Pilih Tipe Supplier --</option>
                                    <option value="Manufaktur"
                                        {{ old('type_suppliers', $dataSupplierById->type_suppliers) == 'Manufaktur' ? 'selected' : '' }}>
                                        Manufaktur</option>
                                    <option value="Kuliner"
                                        {{ old('type_suppliers', $dataSupplierById->type_suppliers) == 'Kuliner' ? 'selected' : '' }}>
                                        Kuliner</option>
                                    <option value="Garment"
                                        {{ old('type_suppliers', $dataSupplierById->type_suppliers) == 'Garment' ? 'selected' : '' }}>
                                        Garment</option>
                                </select>
                                @error('type_suppliers')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="branch_company_id" class="form-label">Cabang <span
                                        class="text-danger">*</span></label>
                                <select name="branch_company_id" id="branch_company_id"
                                    class="form-select @error('branch_company_id') is-invalid @enderror" required>
                                    <option value="" disabled>-- Pilih Cabang --</option>
                                    @foreach ($branchCompany as $data)
                                        <option value="{{ $data->id }}"
                                            {{ old('branch_company_id', $dataSupplierById->branch_company_id) == $data->id ? 'selected' : '' }}>
                                            {{ $data->name_branch_company }}
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
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email', $dataSupplierById->email) }}"
                                    placeholder="contoh@email.com" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="website" class="form-label">Website <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('website') is-invalid @enderror"
                                    id="website" name="website" value="{{ old('website', $dataSupplierById->website) }}"
                                    placeholder="https://example.com" required>
                                @error('website')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone_number" class="form-label">No. Telepon Supplier <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">+62</span>
                                    <input type="number" class="form-control @error('phone_number') is-invalid @enderror"
                                        id="phone_number" name="phone_number"
                                        value="{{ old('phone_number', $dataSupplierById->phone_number) }}"
                                        placeholder="8123456789" required>
                                    @error('phone_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="brand" class="form-label">Brand Produk <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('brand') is-invalid @enderror"
                                    id="brand" name="brand" value="{{ old('brand', $dataSupplierById->brand) }}"
                                    placeholder="Masukkan brand supplier" required>
                                @error('brand')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="address" class="form-label">Alamat Supplier</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3"
                                    placeholder="Masukkan alamat lengkap supplier">{{ old('address', $dataSupplierById->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="address_shipping" class="form-label">Alamat Pengiriman <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control @error('address_shipping') is-invalid @enderror" id="address_shipping"
                                    name="address_shipping" rows="3" placeholder="Masukkan alamat pengiriman" required>{{ old('address_shipping', $dataSupplierById->address_shipping) }}</textarea>
                                @error('address_shipping')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CARD 2: Data PIC --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h4><i class="bi bi-person-badge me-2"></i>Data PIC (Penanggung Jawab)</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="name_pic" class="form-label">Nama PIC <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name_pic') is-invalid @enderror"
                                    id="name_pic" name="name_pic"
                                    value="{{ old('name_pic', $dataSupplierById->name_pic) }}"
                                    placeholder="Masukkan nama PIC" required>
                                @error('name_pic')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="phone_number_pic" class="form-label">No. Telepon PIC <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">+62</span>
                                    <input type="number"
                                        class="form-control @error('phone_number_pic') is-invalid @enderror"
                                        id="phone_number_pic" name="phone_number_pic"
                                        value="{{ old('phone_number_pic', $dataSupplierById->phone_number_pic) }}"
                                        placeholder="8123456789" required>
                                    @error('phone_number_pic')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="position_pic" class="form-label">Jabatan PIC</label>
                                <input type="text" class="form-control @error('position_pic') is-invalid @enderror"
                                    id="position_pic" name="position_pic"
                                    value="{{ old('position_pic', $dataSupplierById->position_pic) }}"
                                    placeholder="Contoh: Manager Procurement">
                                @error('position_pic')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CARD 3: Informasi Pembayaran --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h4><i class="bi bi-credit-card me-2"></i>Informasi Pembayaran</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="bank" class="form-label">Nama Bank <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('bank') is-invalid @enderror"
                                    id="bank" name="bank" value="{{ old('bank', $dataSupplierById->bank) }}"
                                    placeholder="Contoh: BCA, Mandiri" required>
                                @error('bank')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="no_rek" class="form-label">No. Rekening <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('no_rek') is-invalid @enderror"
                                    id="no_rek" name="no_rek" value="{{ old('no_rek', $dataSupplierById->no_rek) }}"
                                    placeholder="Masukkan no. rekening" required min="1">
                                @error('no_rek')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="method_payment" class="form-label">Metode Pembayaran <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('method_payment') is-invalid @enderror"
                                    id="method_payment" name="method_payment"
                                    value="{{ old('method_payment', $dataSupplierById->method_payment) }}"
                                    placeholder="Contoh: Transfer, COD" required>
                                @error('method_payment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="top" class="form-label">Jatuh Tempo <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('top') is-invalid @enderror"
                                        id="top" name="top" value="{{ old('top', $dataSupplierById->top) }}"
                                        placeholder="Maks 30" max="30" required>
                                    <span class="input-group-text">Hari</span>
                                    @error('top')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="limit_kredit" class="form-label">Limit Kredit <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('limit_kredit') is-invalid @enderror"
                                    id="limit_kredit" name="limit_kredit"
                                    value="{{ old('limit_kredit', $dataSupplierById->limit_kredit) }}" required>
                                @error('limit_kredit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CARD 4: Informasi Pengiriman --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h4><i class="bi bi-truck me-2"></i>Informasi Pengiriman</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="method_shipping" class="form-label">Metode Pengiriman <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('method_shipping') is-invalid @enderror"
                                    id="method_shipping" name="method_shipping"
                                    value="{{ old('method_shipping', $dataSupplierById->method_shipping) }}"
                                    placeholder="Contoh: JNE, J&T" required>
                                @error('method_shipping')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="duration_shipping" class="form-label">Durasi Pengiriman <span
                                        class="text-danger">*</span></label>
                                <input type="text"
                                    class="form-control @error('duration_shipping') is-invalid @enderror"
                                    id="duration_shipping" name="duration_shipping"
                                    value="{{ old('duration_shipping', $dataSupplierById->duration_shipping) }}"
                                    placeholder="Contoh: 2-3 hari kerja" required>
                                @error('duration_shipping')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="id_region" class="form-label">ID Region <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('id_region') is-invalid @enderror"
                                    id="id_region" name="id_region"
                                    value="{{ old('id_region', $dataSupplierById->id_region) }}" min="0" required>
                                @error('id_region')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="sales" class="form-label">Nama Sales <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('sales') is-invalid @enderror"
                                    id="sales" name="sales" value="{{ old('sales', $dataSupplierById->sales) }}"
                                    placeholder="Masukkan nama sales" required>
                                @error('sales')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CARD 5: Dokumen Legal --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h4><i class="bi bi-file-earmark-text me-2"></i>Dokumen Legal</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="npwp" class="form-label">NPWP <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('npwp') is-invalid @enderror"
                                    id="npwp" name="npwp" value="{{ old('npwp', $dataSupplierById->npwp) }}"
                                    placeholder="Masukkan nomor NPWP" required>
                                @error('npwp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="scan_npwp" class="form-label">Upload Scan NPWP</label>
                                <input type="file" class="form-control @error('scan_npwp') is-invalid @enderror"
                                    id="scan_npwp" name="scan_npwp" onchange="previewFile(event, 'npwp')">
                                @error('scan_npwp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                {{-- Preview file baru --}}
                                <div class="mt-3" id="preview-container-npwp" style="display:none;">
                                    <p class="mb-1 fw-bold text-muted" style="font-size:13px;">Preview NPWP baru:</p>
                                    <img id="preview-image-npwp" src="#" alt="Preview NPWP"
                                        style="max-width: 280px; border: 1px solid #dee2e6; border-radius: 6px;">
                                    <iframe id="preview-pdf-npwp"
                                        style="width:100%; height:300px; border:1px solid #dee2e6; display:none; border-radius:6px;"></iframe>
                                </div>

                                {{-- Preview file lama NPWP --}}
                                @if ($dataSupplierById->scan_npwp)
                                    <div class="mt-3 p-3 rounded" style="background:#f8fafc; border: 1px solid #e2e8f0;">
                                        <p class="mb-2 text-muted" style="font-size:12px;">
                                            <i class="bi bi-paperclip me-1"></i> File NPWP tersimpan: (File Lama)
                                        </p>
                                        @php
                                            $npwpExt = pathinfo($dataSupplierById->scan_npwp, PATHINFO_EXTENSION);
                                        @endphp

                                        @if (in_array(strtolower($npwpExt), ['jpg', 'jpeg', 'png', 'webp']))
                                            <img src="{{ asset($dataSupplierById->scan_npwp) }}" alt="Scan NPWP"
                                                class="rounded"
                                                style="max-height: 10px; max-width:30px border: 1px solid #dee2e6;">
                                        @elseif(strtolower($npwpExt) == 'pdf')
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="bi bi-file-earmark-pdf text-danger" style="font-size:24px;"></i>
                                                <a href="{{ asset($dataSupplierById->scan_npwp) }}" target="_blank"
                                                    class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-eye me-1"></i> Lihat PDF NPWP
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="siup" class="form-label">SIUP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('siup') is-invalid @enderror"
                                    id="siup" name="siup" value="{{ old('siup', $dataSupplierById->siup) }}"
                                    placeholder="Masukkan nomor SIUP" required>
                                @error('siup')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="scan_siup" class="form-label">Upload Scan SIUP</label>
                                <input type="file" class="form-control @error('scan_siup') is-invalid @enderror"
                                    id="scan_siup" name="scan_siup" onchange="previewFile(event, 'siup')">
                                @error('scan_siup')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                {{-- Preview file baru --}}
                                <div class="mt-3" id="preview-container-siup" style="display:none;">
                                    <p class="mb-1 fw-bold text-muted" style="font-size:13px;">Preview SIUP baru:</p>
                                    <img id="preview-image-siup" src="#" alt="Preview SIUP"
                                        style="max-width: 280px; border: 1px solid #dee2e6; border-radius: 6px;">
                                    <iframe id="preview-pdf-siup"
                                        style="width:100%; height:300px; border:1px solid #dee2e6; display:none; border-radius:6px;"></iframe>
                                </div>

                                {{-- Preview file lama SIUP --}}
                                @if ($dataSupplierById->scan_siup)
                                    <div class="mt-3 p-3 rounded" style="background:#f8fafc; border: 1px solid #e2e8f0;">
                                        <p class="mb-2 text-muted" style="font-size:12px;">
                                            <i class="bi bi-paperclip me-1"></i> File SIUP tersimpan:
                                        </p>
                                        @php
                                            $siupExt = pathinfo($dataSupplierById->scan_siup, PATHINFO_EXTENSION);
                                        @endphp

                                        @if (in_array(strtolower($siupExt), ['jpg', 'jpeg', 'png', 'webp']))
                                            <img src="{{ asset($dataSupplierById->scan_siup) }}" alt="Scan SIUP"
                                                class="rounded" style="max-height: 120px; border: 1px solid #dee2e6;">
                                        @elseif(strtolower($siupExt) == 'pdf')
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="bi bi-file-earmark-pdf text-danger" style="font-size:24px;"></i>
                                                <a href="{{ asset($dataSupplierById->scan_siup) }}" target="_blank"
                                                    class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-eye me-1"></i> Lihat PDF SIUP
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="d-flex justify-content-end gap-2 mb-5">
                <a href="{{ route('supplier-company.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-1"></i> Batal
                </a>
                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-pencil-square me-1"></i> Update Supplier
                </button>
            </div>

        </form>
    </div>
@endsection

@push('scripts')
    <script>
        function blockInvalidChars(ids) {
            ids.forEach(id => {
                const el = document.getElementById(id);
                if (!el) return;
                el.addEventListener('keydown', e => {
                    if (['e', 'E', '-', '+'].includes(e.key)) e.preventDefault();
                });
                el.addEventListener('input', function() {
                    this.value = this.value.replace(/[^0-9]/g, '');
                });
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            blockInvalidChars(['phone_number', 'phone_number_pic', 'top', 'limit_kredit']);
        });

        function previewFile(event, type) {
            const file = event.target.files[0];
            const container = document.getElementById('preview-container-' + type);
            const image = document.getElementById('preview-image-' + type);
            const pdf = document.getElementById('preview-pdf-' + type);

            if (!file) {
                container.style.display = 'none';
                return;
            }

            const url = URL.createObjectURL(file);
            container.style.display = 'block';

            if (file.type.includes('pdf')) {
                image.style.display = 'none';
                pdf.style.display = 'block';
                pdf.src = url;
            } else if (file.type.includes('image')) {
                pdf.style.display = 'none';
                image.style.display = 'block';
                image.src = url;
            } else {
                container.style.display = 'none';
            }
        }
    </script>
@endpush
