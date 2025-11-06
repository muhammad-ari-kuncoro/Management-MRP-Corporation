@extends('layouts.layouts_dashboard')

@section('page-content')
<div class="card shadow-sm border-8 mb-3">
    <div class="card-header bg-light mb-5">
        <h5 class="mb-0">Tambah Bills of Materials</h5>
    </div>

    <div class="col-12 mt-3">
        @include('layouts.component_alerts')
    </div>

    <div class="card-body">
        {{-- ================= HEADER BOM ================= --}}
        <form id="bomForm" action="{{ route('bills-of-materials.store')}}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">

                    <div class="mb-3">
                        <label>Kode BOM</label>
                        <input type="text" class="form-control" name="code_bom"
                            value="{{ old('code_bom', 'BOM-' . now()->format('Ymd')) }}" readonly>
                        @error('code_bom') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label>Revisi</label>
                        <input type="text" class="form-control" name="revision"
                            value="{{ old('revision', 'R1') }}">
                        @error('revision') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- <div class="mb-3">
                        <label>Status</label>
                        <select name="status" class="form-select" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                    </div> --}}

                </div>

                <div class="col-md-6">

                    <div class="mb-3">
                        <label>Tanggal BOM</label>
                        <input type="date" class="form-control" name="date_bom"
                            value="{{ old('date_bom', date('Y-m-d')) }}">
                        @error('date_bom') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label>Catatan</label>
                        <textarea class="form-control" name="notes" placeholder="Masukkan catatan">{{ old('notes') }}</textarea>
                        @error('notes') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                </div>
            </div>

            {{-- Tombol Simpan Header --}}
            <div class="d-flex justify-content-between mt-3">
                <a href="{{ route('bills-of-materials.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-send"></i> Simpan dan Buat BOM
                </button>
            </div>
        </form>

        {{-- ================= DETAIL BOM ================= --}}
        <hr>
        <h6 class="fw-bold mb-3">Detail Material</h6>

        @include('bills-of-materials.create_detail')

        {{-- ================= TABEL ITEM ================= --}}
        <div class="table-responsive mt-4">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Kode Item</th>
                        <th>Nama Item</th>
                        <th>Spesifikasi</th>
                        <th>Qty</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($detail_BOM ?? [] as $detail)
                    <tr>
                        <td>{{ $detail->items->kd_item ?? '-' }}</td>
                        <td>{{ $detail->items->name_item ?? '-' }}</td>
                        <td>{{ $detail->items->spesification ?? '-' }}</td>
                        <td>{{ $detail->plan_qty }}</td>
                        <td>{{ $detail->notes ?: '-' }}</td>
                        <td>
                            <form action="{{ route('bills-of-materials.bills-of-materials.destroy', $detail->id) }}" method="POST" onsubmit="return confirm('Hapus item ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada item ditambahkan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
