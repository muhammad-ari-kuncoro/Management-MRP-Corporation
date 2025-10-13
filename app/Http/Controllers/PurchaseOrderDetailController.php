<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
class PurchaseOrderDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    // Cari PO dengan status draft milik user aktif
    $po_draft = PurchaseOrder::where('user_id', Auth::id())
        ->where('status', 'draft')
        ->first();

    // Jika belum ada draft, buat baru otomatis
    if (!$po_draft) {
        $po_draft = PurchaseOrder::create([
            'user_id' => Auth::id(),
            'po_no' => 'PO-' . strtoupper(uniqid()),
            'po_date' => now(),
            'status' => 'draft',
        ]);
    }

    // Ambil semua item untuk dropdown
    $data['items'] = Items::all();

    // Simpan PO draft ke view
    $data['po_draft'] = $po_draft;

    // Ambil detail barang untuk PO draft
    $data['detail_po'] = PurchaseOrderDetail::with('items')
        ->where('purchase_order_id', $po_draft->id)
        ->get();

    return view('purchase-order-detail.index', $data);
}

 public function create(Request $request)
{
      $request->validate([
        'items_id' => 'required',
        'qty' => 'required|numeric|min:1',
        'discount' => 'required|numeric|min:0|max:100',
    ]);
    // dd($request);


    // 1️⃣ Cek apakah sudah ada PO draft untuk user ini
    $purchaseOrder = PurchaseOrder::where('user_id', Auth::id())
        ->where('status', 'draft')
        ->latest()
        ->first();

    // 2️⃣ Kalau belum ada, buat otomatis
    if (!$purchaseOrder) {
        $purchaseOrder = PurchaseOrder::create([
            'po_no' => 'PO-' . now()->format('Ymd'),
            'po_date' => now(),
            'estimation_delivery_date' => 'NULLABLE',
            'note' => 'NULLABLE',
            'term_of_payment' => 'NULLABLE',
            'currency' => 1,
            'currency_rate' => 1,
            'transportation_fee' => 'NULLABLE',
            'journal_id' => 'NULLABLE',
            'user_id' => Auth::id(),
            'status' => 'draft',
        ]);

    }


    $item = Items::findOrFail($request->items_id);
    $price = $item->price_item;
    $qty = $request->qty;
    $hasilQuantityKaliprice = $price * $qty;
    $discount = $request->discount;
    $total = ($hasilQuantityKaliprice) - ($hasilQuantityKaliprice * ($discount / 100));
    // 1 10 135
    // 3️⃣ Buat detail item
    PurchaseOrderDetail::create([
        'purchase_order_id' => $purchaseOrder->id,
        'items_id' => $item->id,
        'qty' => $qty,
        'discount' => $discount,
        'total' => $total
    ]);

    return redirect()->back()->with('success', 'Item berhasil ditambahkan ke Purchase Order (Draft)');
}



    /**
     * Update qty dan discount item
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'qty' => 'required|integer|min:1',
            'discount' => 'nullable|numeric|min:0'
        ]);

        DB::beginTransaction();
        try {
            $detail = PurchaseOrderDetail::findOrFail($id);
            $item = Items::findOrFail($detail->items_id);

            // Hitung ulang total
            $total = ($item->discount * $request->qty) - ($request->discount ?? 0);

            $detail->update([
                'qty' => $request->qty,
                'discount' => $request->discount ?? 0,
                'total' => $total
            ]);

            DB::commit();
            return redirect()->back()
                ->with('success', 'Item berhasil diupdate.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal update item: ' . $e->getMessage());
        }
    }

    /**
     * Delete item dari purchase order
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $detail = PurchaseOrderDetail::findOrFail($id);

            // Cek status PO
            $purchaseOrder = PurchaseOrder::findOrFail($detail->purchase_order_id);
            if ($purchaseOrder->status !== 'draft') {
                return redirect()->back()
                    ->with('error', 'Purchase Order sudah diajukan, tidak dapat menghapus item.');
            }

            $detail->delete();

            DB::commit();
            return redirect()->back()
                ->with('success', 'Item berhasil dihapus dari Purchase Order.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menghapus item: ' . $e->getMessage());
        }
    }

    /**
     * AJAX: Update qty real-time
     */
    public function updateQty(Request $request)
    {
        $request->validate([
            'detail_id' => 'required|exists:tb_purchase_orders_details,id',
            'qty' => 'required|integer|min:1'
        ]);

        try {
            $detail = PurchaseOrderDetail::findOrFail($request->detail_id);
            $item = Items::findOrFail($detail->items_id);

            // Hitung ulang total
            $total = ($item->discount * $request->qty) - $detail->discount;

            $detail->update([
                'qty' => $request->qty,
                'total' => $total
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Qty berhasil diupdate',
                'total' => $total,
                'formatted_total' => 'Rp ' . number_format($total, 0, ',', '.')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal update qty: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * AJAX: Update discount real-time
     */
    public function updateDiscount(Request $request)
    {
        $request->validate([
            'detail_id' => 'required|exists:tb_purchase_orders_details,id',
            'discount' => 'required|numeric|min:0'
        ]);

        try {
            $detail = PurchaseOrderDetail::findOrFail($request->detail_id);
            $item = Items::findOrFail($detail->items_id);

            // Hitung ulang total
            $total = ($item->discount * $detail->qty) - $request->discount;

            $detail->update([
                'discount' => $request->discount,
                'total' => $total
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Discount berhasil diupdate',
                'total' => $total,
                'formatted_total' => 'Rp ' . number_format($total, 0, ',', '.')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal update discount: ' . $e->getMessage()
            ], 500);
        }
    }
}
