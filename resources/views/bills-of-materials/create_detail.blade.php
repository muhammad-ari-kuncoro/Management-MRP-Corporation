<form id="bomDetailForm" action="{{route('bills-of-materials.store-detail')}}" method="POST">
            @csrf
            <input type="hidden" name="bom_id" value="{{ $bom->id ?? '' }}">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <label>Nama Item</label>
                    <select name="item_id" class="form-select" required>
                        <option value="">-- Pilih Item --</option>
                        @foreach($data_items ?? [] as $item)
                        <option value="{{ $item->id }}">{{ $item->name_item }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Quantity (Qty)</label>
                    <input type="number" name="plan_qty" class="form-control" min="1" value="1">
                </div>

                <div class="col-md-3">
                    <label>Catatan</label>
                    <input type="text" name="notes" class="form-control" placeholder="Catatan opsional">
                </div>

                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-primary mt-2">
                        <i class="bi bi-plus-circle"></i> Tambah
                    </button>
                </div>
            </div>
        </form>
