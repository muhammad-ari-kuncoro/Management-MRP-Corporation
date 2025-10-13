@extends('layouts.layouts_dashboard')
@section('row')

@section('page-content')
<div class="card shadow-sm border-8 mb-3">
    <div class="card-header bg-light mb-5">
        <h5 class="mb-0">Detail Purchase Order</h5>
    </div>

    <div class="card-body">
        {{-- Form Purchase Order Header --}}
        <form id="purchaseOrderForm" method="post" action="{{ route('purchase-order.store') }}"
            enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label>No PO</label>
                        <input type="text" class="form-control" name="po_no"
                            value="{{ $purchaseOrder->po_no ?? 'PO-' . now()->format('ymd') }}" readonly disabled>

                    </div>

                    <div class="mb-3">
                        <label>Supplier</label>
                        <select class="form-select" name="supplier_id" required>
                            <option value="">-- Pilih Supplier --</option>
                            @foreach($suppliers ?? [] as $supplier)
                            <option value="{{ $supplier->id }}"
                                {{ (isset($purchaseOrder) && $purchaseOrder->supplier_id == $supplier->id) ? 'selected' : '' }}>
                                {{ $supplier->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-6 mb-3">
                            <label>Tempo Bayar</label>
                            <input type="number" class="form-control" name="term_of_payment"
                                value="{{ $purchaseOrder->term_of_payment ?? '30' }}">
                        </div>
                        <div class="col-6 mb-3 d-flex align-items-end">
                            <span>Hari</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>No Referensi</label>
                        <input type="text" class="form-control" name="reference_no"
                            placeholder="Masukkan nomor referensi" value="{{ $purchaseOrder->reference_no ?? '' }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label>Tanggal PO</label>
                            <input type="date" class="form-control" name="po_date"
                                value="{{ $purchaseOrder->po_date ?? date('Y-m-d') }}" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label>Rencana Terima</label>
                            <input type="date" class="form-control" name="estimation_delivery_date"
                                value="{{ $purchaseOrder->estimation_delivery_date ?? date('Y-m-d', strtotime('+30 days')) }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Catatan</label>
                        <textarea class="form-control" name="note"
                            placeholder="Masukkan catatan">{{ $purchaseOrder->note ?? '' }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label>Gudang</label>
                        <select class="form-select" name="warehouse_id">
                            <option value="">-- Pilih Gudang --</option>
                            @foreach($warehouses ?? [] as $warehouse)
                            <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <label>Kurs</label>
                        <div class="col-6 mb-3">
                            <select class="form-select" name="currency">
                                <option value="IDR">IDR - Indonesia</option>
                                <option value="USD">USD - US Dollar</option>
                            </select>
                        </div>
                        <div class="col-6 mb-3">
                            <input type="number" class="form-control" name="currency_rate" placeholder="1"
                                value="{{ $purchaseOrder->currency_rate ?? 1 }}">
                        </div>
                    </div>
                </div>
            </div>

            <hr>


        </form>

        {{-- Form untuk tambah detail item (TERPISAH dari form header) --}}
        <form action="{{route('purchase-order-detail.create')}}" method="post" id="purchaseOrderDetailForm">
            @csrf
            @if($po_draft)
            <input type="hidden" name="purchase_order_id" value="{{ $po_draft->id }}">
            @else
            <!-- Handle jika tidak ada PO draft yang ditemukan -->
            <p class="text-danger text-center">Anda harus membuat Purchase Order draft terlebih dahulu.</p>
            @endif

            <div class="row align-items-end">
                {{-- Kode Item --}}
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="kd_item" class="form-label">Kode Item</label>
                        <input type="text" name="kd_item" id="kd_item" class="form-control" readonly disabled>
                    </div>
                </div>

                {{-- Nama Item --}}
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="items_id" class="form-label">Nama Item</label>
                        <select name="items_id" id="items_id" class="form-select" name="items_id" required>
                            <option value="" disabled selected>-- Pilih Nama Item --</option>
                            @foreach($items ?? [] as $item)
                            <option value="{{ $item->id }}" data-kode="{{ $item->kd_item }}"
                                data-price="{{ $item->price_item }}">
                                {{ $item->name_item }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Qty --}}
                <div class="col-md-2">
                    <div class="mb-3">
                        <label for="qty" class="form-label">Qty</label>
                        <input type="number" name="qty" id="qty" class="form-control" placeholder="0" min="1" required>
                    </div>
                </div>

                {{-- Discount --}}
                <div class="col-md-2">
                    <div class="mb-3">
                        <label for="discount" class="form-label">Discount</label>
                        <input type="number" name="discount" id="discount" class="form-control" placeholder="0" min="0" max="100"
                            value="0">
                    </div>
                </div>

                {{-- Tombol Simpan --}}
                <div class="col-md-1">
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-plus"></i> Tambah
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <hr>

        {{-- Tabel Barang --}}
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
                        <td class="text-center">
                            {{ $data->qty}}
                        </td>
                        <td>{{ $data->items->type ?? '-' }}</td>
                        <td>Rp {{ number_format($data->items->price_item ?? 0, 2, ',', '.') }}</td>
                        <td>
                            {{ rtrim(rtrim(number_format($data->discount ?? 0, 2, '.', ''), '0'), '.') }}%

                        </td>

                        <td class="total-cell">
                            Rp {{ number_format($data->total, 0, ',', '.') }}
                        </td>

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


        {{-- Bagian Total --}}
        <div class="row justify-content-end">
            <div class="col-md-5">
                <table class="table">
                    <tr>
                        <td>Subtotal</td>
                        <td class="text-end subtotal-value">Rp
                            {{ number_format($purchaseOrder->subtotal ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Total Diskon</td>
                        <td class="text-end discount-value">
                            {{ rtrim(rtrim(number_format($purchaseOrder->totalDiscount ?? 0, 2, '.', ''), '0'), '.') }}%
                        </td>


                    </tr>
                    <tr>
                        <td>PPN (11%)</td>
                        <td class="text-end">
                            <input type="number" id="ppn-input" class="form-control form-control-sm text-end"
                                value="{{ $purchaseOrder->ppn ?? 0 }}" readonly>
                        </td>
                    </tr>
                    <tr>
                        <td>Biaya Pengiriman</td>
                        <td class="text-end">
                            <input type="number" id="shipping-input" class="form-control form-control-sm text-end"
                                value="{{ $purchaseOrder->transportation_fee ?? 0 }}" min="0">
                        </td>
                    </tr>
                    <tr class="table-light fw-bold">
                        <td>Grand Total</td>
                        <td class="text-end grand-total-value">Rp
                            {{ number_format($purchaseOrder->grandTotal ?? 0, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Form untuk submit PO --}}
        <form action="{{route('purchase-order.update', $purchaseOrder->id ?? '')}}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Upload File --}}
            <div class="mb-3">
                <label>Attachment</label>
                <input type="file" class="form-control" name="attachment">
                @if(isset($purchaseOrder) && $purchaseOrder->attachment)
                <small class="text-muted">File saat ini: {{ basename($purchaseOrder->attachment) }}</small>
                @endif
            </div>

            {{-- Tombol --}}
            <div class="d-flex justify-content-between">
                <a href="{{route('purchase-order.index')}}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <div>
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                    <button type="button" class="btn btn-success" onclick="submitPO()">
                        <i class="bi bi-send"></i> Simpan dan Ajukan PO
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Handle select item untuk mengisi kode item
        const select = document.getElementById('items_id');
        const kdInput = document.getElementById('kd_item');

        if (select && kdInput) {
            select.addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];
                const kodeItem = selectedOption ? selectedOption.getAttribute('data-kode') : '';
                kdInput.value = kodeItem || '';
            });
        }

        // Handle perubahan qty secara real-time
        document.querySelectorAll('.qty-input').forEach(input => {
            input.addEventListener('input', function () {
                updateRowTotal(this);
            });
        });

        // Handle perubahan discount secara real-time
        document.querySelectorAll('.discount-input').forEach(input => {
            input.addEventListener('input', function () {
                updateRowTotal(this);
            });
        });

        // Handle perubahan biaya pengiriman
        const shippingInput = document.getElementById('shipping-input');
        if (shippingInput) {
            shippingInput.addEventListener('input', function () {
                updateGrandTotal();
            });
        }

        // Fungsi untuk update total per row
        function updateRowTotal(element) {
            const row = element.closest('tr');
            const price = parseFloat(element.dataset.price);
            const qtyInput = row.querySelector('.qty-input');
            const discountInput = row.querySelector('.discount-input');
            const totalCell = row.querySelector('.total-cell');

            const qty = parseInt(qtyInput.value) || 0;
            const discount = parseFloat(discountInput.value) || 0;

            // Hitung total
            const subtotal = price * qty;
            const total = subtotal - discount;

            // Update tampilan total
            if (totalCell) {
                totalCell.textContent = "Rp " + total.toLocaleString('id-ID');
            }

            // Update grand total
            updateGrandTotal();
        }

        // Fungsi untuk menghitung grand total
        function updateGrandTotal() {
            let subtotal = 0;
            let totalDiscount = 0;

            // Loop semua row untuk hitung subtotal
            document.querySelectorAll('#itemTableBody tr[data-id]').forEach(row => {
                const qtyInput = row.querySelector('.qty-input');
                const discountInput = row.querySelector('.discount-input');

                if (qtyInput) {
                    const price = parseFloat(qtyInput.dataset.price);
                    const qty = parseInt(qtyInput.value) || 0;
                    const discount = parseFloat(discountInput.value) || 0;

                    subtotal += (price * qty);
                    totalDiscount += discount;
                }
            });

            // Hitung PPN 11%
            const ppn = subtotal * 0.11;

            // Ambil biaya pengiriman
            const shippingInput = document.getElementById('shipping-input');
            const shipping = shippingInput ? parseFloat(shippingInput.value) || 0 : 0;

            // Hitung grand total
            const grandTotal = subtotal - totalDiscount + ppn + shipping;

            // Update tampilan
            const subtotalElement = document.querySelector('.subtotal-value');
            const discountElement = document.querySelector('.discount-value');
            const ppnInput = document.getElementById('ppn-input');
            const grandTotalElement = document.querySelector('.grand-total-value');

            if (subtotalElement) subtotalElement.textContent = "Rp " + subtotal.toLocaleString('id-ID');
            if (discountElement) discountElement.textContent = totalDiscount.toString().replace(/\.0+$/, '') + "%";
            if (ppnInput) ppnInput.value = Math.round(ppn);
            if (grandTotalElement) grandTotalElement.textContent = "Rp " + grandTotal.toLocaleString('id-ID');
        }

        // Initial calculation
        updateGrandTotal();
    });

    // Function untuk submit PO
    function submitPO() {
        if (confirm('Apakah Anda yakin ingin mengajukan Purchase Order ini?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = "{{ route('purchase-order.submit', $purchaseOrder->id ?? '') }}";

            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);

            document.body.appendChild(form);
            form.submit();
        }
    }

</script>

@endsection
