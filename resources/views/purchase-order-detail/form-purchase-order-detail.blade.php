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
                    <input type="number" name="discount" id="discount" class="form-control" placeholder="0" min="0"
                        max="100" value="0">
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
