@extends('layouts.layouts_dashboard')

@section('page-content')
<div class="card shadow-sm border-8 mb-3">
    <div class="card-header bg-light mb-5">
        <h5 class="mb-0">Detail Purchase Order</h5>
    </div>
    <div class="col-12 mt-3">
        @include('layouts.component_alerts')
    </div>
    <div class="card-body">
        {{-- ================= HEADER PO ================= --}}
        <form id="purchaseOrderForm" action="{{ route('purchase-order.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label>No PO</label>
                        <input type="text" class="form-control" name="po_no"
                            value="{{ old('po_no', $purchaseOrder->po_no ?? 'PO-' . now()->format('Ymd')) }}" readonly>
                            @error('po_no') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label>Supplier</label>
                        <select class="form-select" name="supplier_id" required>
                            <option value="">-- Pilih Supplier --</option>
                            @foreach($dataSupplier ?? [] as $supplier)
                            <option value="{{ $supplier->id }}"
                                {{ (old('supplier_id', $purchaseOrder->supplier_id ?? '') == $supplier->id) ? 'selected' : '' }}>
                                {{ $supplier->name_suppliers }}
                            </option>
                            @endforeach
                        </select>
                        @error('supplier_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Bagian Total --}}
                    <div class="row">
                        <div class="col">
                            <table class="table">
                                <tr>
                                    <td>Subtotal</td>
                                    <td class="text-end subtotal-value">
                                        <input type="text" name="sub_total" id="subtotal-input"
                                            class="form-control form-control-sm text-end"
                                            value="Rp {{ number_format($purchaseOrder->subtotal ?? 0, 2, ',', '.') }}"
                                            readonly>
                                             @error('sub_total') <small class="text-danger">{{ $message }}</small> @enderror
                                    </td>
                                </tr>

                                <tr>
                                    <td>Total Diskon</td>
                                    <td class="text-end discount-value">
                                        <input type="text" name="total_diskon_harga" id="discount-input"
                                            class="form-control form-control-sm text-end"
                                            value="{{ number_format($purchaseOrder->totalDiscount ?? 1, 0, ',', '.') }} %"
                                            readonly>
                                             @error('total_diskon_harga') <small class="text-danger">{{ $message }}</small> @enderror
                                    </td>
                                </tr>

                                <tr>
                                    <td>PPN (%)</td>
                                    <td class="text-end">
                                        <input type="number" name="PPN" id="ppn-input"
                                            class="form-control form-control-sm text-end" value="11" readonly>
                                             @error('PPN') <small class="text-danger">{{ $message }}</small> @enderror
                                    </td>
                                </tr>

                                <tr>
                                    <td>Biaya Pengiriman</td>
                                    <td class="text-end">
                                        <input type="number" name="transportation_fee" id="shipping-input"
                                            class="form-control form-control-sm text-end"
                                            value="{{ $purchaseOrder->transportation_fee ?? 0 }}" min="0">
                                             @error('transportation_fee') <small class="text-danger">{{ $message }}</small> @enderror
                                    </td>
                                </tr>

                                <tr class="table-light fw-bold">
                                    <td>Grand Total</td>
                                    <td class="text-end grand-total-value">
                                        <input type="text" name="grand_total" id="grand-total-input"
                                            class="form-control form-control-sm text-end"
                                            value="Rp {{ number_format($purchaseOrder->grandTotal ?? 0, 2, ',', '.') }}"
                                            readonly>
                                            @error('grand_total') <small class="text-danger">{{ $message }}</small> @enderror

                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>

                <div class="col-md-6">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label>Tanggal PO</label>
                            <input type="date" class="form-control" name="po_date"
                                value="{{ old('po_date', $purchaseOrder->po_date ?? date('Y-m-d')) }}" readonly>
                                @error('po_date') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label>Rencana Terima</label>
                            <input type="date" class="form-control" name="estimation_delivery_date"
                                value="{{ old('estimation_delivery_date', $purchaseOrder->estimation_delivery_date ?? date('Y-m-d', strtotime('+30 days'))) }}">
                                @error('estimation_delivery_date') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Catatan</label>
                        <textarea class="form-control" name="note"
                            placeholder="Masukkan catatan">{{ old('note', $purchaseOrder->note ?? '') }}</textarea>
                             @error('note') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="row">
                        <label>Kurs</label>
                        <div class="col-6 mb-3">
                            <select class="form-select" name="currency">
                                <option value="IDR"
                                    {{ (old('currency', $purchaseOrder->currency ?? '') == 'IDR') ? 'selected' : '' }}>
                                    IDR - Indonesia</option>
                                <option value="USD"
                                    {{ (old('currency', $purchaseOrder->currency ?? '') == 'USD') ? 'selected' : '' }}>
                                    USD - US Dollar</option>
                            </select>
                        </div>
                        <div class="col-6 mb-3">
                            <input type="number" class="form-control" name="currency_rate"
                                value="{{ old('currency_rate', $purchaseOrder->currency_rate ?? 1) }}" min="1">
                        </div>

                        <div class="mb-3">
                            <label>Attachment</label>
                            <input type="file" class="form-control" name="attachment" id="attachmentInput"
                                accept="image/*">
                            <div class="mt-2">
                                @if(isset($purchaseOrder) && $purchaseOrder->attachment)
                                <img src="{{ asset('storage/'.$purchaseOrder->attachment) }}" id="attachmentPreview"
                                    alt="Preview Attachment" class="img-thumbnail" style="max-height: 150px;">
                                @else
                                <img id="attachmentPreview" class="img-thumbnail d-none" style="max-height: 150px;">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tombol Simpan Header --}}
            <div class="d-flex justify-content-between mt-3">
                <a href="{{ route('purchase-order.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-success">

                    <i class="bi bi-send" onclick="submitForm()"></i> Simpan dan Ajukan PO
                </button>
            </div>
        </form>

        {{-- ================= DETAIL PO ================= --}}
        <hr>
        @include('purchase-order-detail.form-purchase-order-detail')
        <hr>

        {{-- ================= TABEL ITEM ================= --}}
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Spesifikasi</th>
                        <th class="text-center">Qty</th>
                        <th>Satuan</th>
                        <th>Harga Satuan</th>
                        <th>Diskon</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="itemTableBody">
                    @forelse ($detail_po as $data)
                    <tr data-id="{{ $data->id }}">
                        <td>{{ $data->items->kd_item ?? '-' }}</td>
                        <td>{{ $data->items->name_item ?? '-' }}</td>
                        <td>{{ $data->items->spesification ?? '-' }}</td>
                        <td class="text-center">{{ $data->qty }}</td>
                        <td>{{ $data->items->type ?? '-' }}</td>
                        <td>Rp {{ number_format($data->items->price_item ?? 0, 2, ',', '.') }}</td>
                        <td>{{ rtrim(rtrim(number_format($data->discount ?? 0, 2, '.', ''), '0'), '.') }}%</td>
                        <td class="total-cell">Rp {{ number_format($data->total ?? 0, 2, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('purchase-order-detail.destroy', $data->id) }}" method="POST"
                                class="d-inline" onsubmit="return confirm('Yakin hapus item ini?')">
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
                        <td colspan="9" class="text-center">Belum ada item ditambahkan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ================= SCRIPT ================= --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

  function parseRupiah(value) {
    if (!value) return 0;
    value = String(value).trim();
    const cleaned = value.replace(/[^\d,,-]/g, '').replace(',', '.');
    return parseFloat(cleaned) || 0;
  }

  function updateGrandTotal() {
    let subtotal = 0;
    let totalDiskon = 0;

    // Loop semua baris item di tabel
    const rows = document.querySelectorAll('#itemTableBody tr[data-id]');
    rows.forEach(row => {
      const totalCell = row.querySelector('.total-cell') || row.querySelector('td:nth-child(8)');
      const discountCell = row.querySelector('.discount-value-cell') || row.querySelector('td:nth-child(7)');

      const totalText = totalCell ? totalCell.textContent : '0';
      const discountText = discountCell ? discountCell.textContent : '0';

      const totalValue = parseRupiah(totalText);
      const discountValue = parseRupiah(discountText);

      subtotal += totalValue;
      totalDiskon += discountValue;
    });

    // Ambil nilai PPN dan Ongkir
    const ppnPersen = parseFloat(document.getElementById('ppn-input')?.value || 11) / 100;
    const shipping = parseRupiah(document.getElementById('shipping-input')?.value || 0);

    // Hitung Grand Total
    const ppn = subtotal * ppnPersen;
    const grandTotal = subtotal + ppn + shipping - totalDiskon;

    // Update tampilan input di bawah tabel
    const subtotalInput = document.querySelector('.subtotal-value input');
    const discountInput = document.querySelector('.discount-value input');
    const grandTotalInput = document.querySelector('.grand-total-value input');

    if (subtotalInput)
      subtotalInput.value = 'Rp ' + subtotal.toLocaleString('id-ID', { minimumFractionDigits: 2 });
    if (discountInput)
      discountInput.value = totalDiskon.toLocaleString('id-ID', { minimumFractionDigits: 0 }) + ' %';
    if (grandTotalInput)
      grandTotalInput.value = 'Rp ' + grandTotal.toLocaleString('id-ID', { minimumFractionDigits: 2 });
  }

  // Jalankan ketika ongkir berubah
  const shippingInput = document.getElementById('shipping-input');
  if (shippingInput) shippingInput.addEventListener('input', updateGrandTotal);

  // Jalankan saat halaman selesai dimuat
  updateGrandTotal();
});


    function submitForm() {
        $("#purchaseOrderForm").submit();
    }
</script>


@endsection
