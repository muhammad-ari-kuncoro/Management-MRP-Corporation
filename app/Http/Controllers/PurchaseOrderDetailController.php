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
    public function index ()
    {
        $data['items'] = Items::all();
        $data['do_draft'] = PurchaseOrder::where('user_id', Auth::user()->id)->where('po_no', 'draft')->first();
        $data['detail_po'] = PurchaseOrderDetail::with('items')->get();
        return view('purchase-order-detail.index',$data);
    }
  public function create(Request $request)
    {
        $request->validate([
            'purchase_order_id' => 'required|exists:tb_purchase_orders,id',
            'items_id' => 'required|exists:items,id',
            'qty' => 'required|integer|min:1',
            'discount' => 'nullable|numeric|min:0'
        ]);

        DB::beginTransaction();
        try {
            $item = Items::findOrFail($request->items_id);

            // Cek apakah item sudah ada di PO detail
            $existingDetail = PurchaseOrderDetail::where('purchase_order_id', $request->purchase_order_id)
                ->where('items_id', $request->items_id)
                ->first();

            if ($existingDetail) {
                // Update qty jika item sudah ada
                $existingDetail->qty += $request->qty;
                $existingDetail->discount = $request->discount ?? 0;
                $existingDetail->total = ($item->price_item * $existingDetail->qty) - $existingDetail->discount;
                $existingDetail->save();
            } else {
                // Tambah item baru
                $total = ($item->price_item * $request->qty) - ($request->discount ?? 0);

                PurchaseOrderDetail::create([
                    'purchase_order_id' => $request->purchase_order_id,
                    'items_id' => $request->items_id,
                    'qty' => $request->qty,
                    'discount' => $request->discount ?? 0,
                    'total' => $total
                ]);
            }

            DB::commit();
            return redirect()->back()
                ->with('success', 'Item berhasil ditambahkan ke Purchase Order.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menambahkan item: ' . $e->getMessage());
        }
    }

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
            $total = ($item->price_item * $request->qty) - ($request->discount ?? 0);

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

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $detail = PurchaseOrderDetail::findOrFail($id);
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
            $total = ($item->price_item * $request->qty) - $detail->discount;

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
            $total = ($item->price_item * $detail->qty) - $request->discount;

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
