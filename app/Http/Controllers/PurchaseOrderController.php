<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
      $data['data_purchase_orders']  = PurchaseOrder::where('po_no', '!=', 'drafts')->get();
      $data['judul'] = 'Form Purchase Order';
        return view('purchase-order.index',$data);
    }


    /**
     * Show the form for creating a new purchase order
     */
    // public function create()
    // {
    //     $suppliers = Supplier::all();
    //     $warehouses = Warehouse::all();
    //     $items = Item::all();

    //     // Generate nomor PO otomatis
    //     $poNumber = $this->generatePONumber();

    //     return view('purchase-order.create', compact('suppliers', 'warehouses', 'items', 'poNumber'));
    // }

    /**
     * Store a newly created purchase order
     */
    public function store(Request $request)
    {
        $request->validate([
            'po_no' => 'required|unique:tb_purchase_orders,po_no',
            'po_date' => 'required|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'estimation_delivery_date' => 'nullable|date',
            'note' => 'nullable|string',
            'currency' => 'nullable|string',
            'currency_rate' => 'nullable|numeric',
            'transportation_fee' => 'nullable|numeric',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        DB::beginTransaction();
        try {
            // Upload file attachment jika ada
            $attachmentPath = null;
            if ($request->hasFile('attachment')) {
                $attachmentPath = $request->file('attachment')->store('purchase-orders', 'public');
            }

            // Generate PO Number jika belum ada
            $poNumber = $request->po_no ?? $this->generatePONumber();

            // Simpan Purchase Order
            $purchaseOrder = PurchaseOrder::create([
                'po_no' => $poNumber,
                'po_date' => $request->po_date,
                'user_id' => Auth::id(),
                'supplier_id' => $request->supplier_id,
                'estimation_delivery_date' => $request->estimation_delivery_date,
                'note' => $request->note,
                'status' => 'draft',
                'currency' => $request->currency ?? 'IDR',
                'currency_rate' => $request->currency_rate ?? 1,
                'transportation_fee' => $request->transportation_fee ?? 0,
                'attachment' => $attachmentPath
            ]);

            DB::commit();

            return redirect()->route('purchase-order.edit', $purchaseOrder->id)
                ->with('success', 'Purchase Order berhasil dibuat. Silakan tambahkan item.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal membuat Purchase Order: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified purchase order
     */
    public function show($id)
    {
        $purchaseOrder = PurchaseOrder::with(['supplier', 'user', 'details.items'])->findOrFail($id);

        return view('purchase-order.show', compact('purchaseOrder'));
    }

    /**
     * Show the form for editing the specified purchase order
     */
    // public function edit($id)
    // {
    //     $purchaseOrder = PurchaseOrder::with(['supplier', 'details.items'])->findOrFail($id);
    //     $suppliers = Supplier::all();
    //     $warehouses = Warehouse::all();
    //     $items = Item::all();
    //     $detail_po = PurchaseOrderDetail::where('purchase_order_id', $id)
    //         ->with('items')
    //         ->get();

    //     return view('purchase-order.edit', compact('purchaseOrder', 'suppliers', 'warehouses', 'items', 'detail_po'));
    // }

    /**
     * Update the specified purchase order
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'po_date' => 'required|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'estimation_delivery_date' => 'nullable|date',
            'term_of_payment' => 'nullable|string',
            'note' => 'nullable|string',
            'currency' => 'nullable|string',
            'currency_rate' => 'nullable|numeric',
            'transportation_fee' => 'nullable|numeric',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        DB::beginTransaction();
        try {
            $purchaseOrder = PurchaseOrder::findOrFail($id);

            // Upload file attachment jika ada
            if ($request->hasFile('attachment')) {
                // Hapus file lama jika ada
                if ($purchaseOrder->attachment) {
                    Storage::disk('public')->delete($purchaseOrder->attachment);
                }
                $attachmentPath = $request->file('attachment')->store('purchase-orders', 'public');
                $purchaseOrder->attachment = $attachmentPath;
            }

            // Update data
            $purchaseOrder->update([
                'po_date' => $request->po_date,
                'supplier_id' => $request->supplier_id,
                'estimation_delivery_date' => $request->estimation_delivery_date,
                'note' => $request->note,
                'term_of_payment' => $request->term_of_payment,
                'currency' => $request->currency ?? 'IDR',
                'currency_rate' => $request->currency_rate ?? 1,
                'transportation_fee' => $request->transportation_fee ?? 0
            ]);

            DB::commit();

            return redirect()->route('purchase-order.edit', $id)
                ->with('success', 'Purchase Order berhasil diupdate.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal update Purchase Order: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified purchase order
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $purchaseOrder = PurchaseOrder::findOrFail($id);

            // Cek apakah PO sudah diapprove
            if ($purchaseOrder->status !== 'draft') {
                return redirect()->back()
                    ->with('error', 'Purchase Order yang sudah diajukan tidak dapat dihapus.');
            }

            // Hapus file attachment jika ada
            if ($purchaseOrder->attachment) {
                Storage::disk('public')->delete($purchaseOrder->attachment);
            }

            // Hapus detail PO (cascade sudah diatur di foreign key, tapi lebih aman manual)
            PurchaseOrderDetail::where('purchase_order_id', $id)->delete();

            // Hapus PO
            $purchaseOrder->delete();

            DB::commit();

            return redirect()->route('purchase-order.index')
                ->with('success', 'Purchase Order berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menghapus Purchase Order: ' . $e->getMessage());
        }
    }

    /**
     * Submit purchase order for approval
     */
    public function submit($id)
    {
        DB::beginTransaction();
        try {
            $purchaseOrder = PurchaseOrder::findOrFail($id);

            // Cek apakah ada detail item
            $detailCount = PurchaseOrderDetail::where('purchase_order_id', $id)->count();
            if ($detailCount == 0) {
                return redirect()->back()
                    ->with('error', 'Tidak dapat mengajukan PO tanpa item. Silakan tambahkan item terlebih dahulu.');
            }

            // Update status ke pending (menunggu approval)
            $purchaseOrder->update([
                'status' => 'pending',
                'approved_at' => null,
                'approved_by' => null
            ]);

            DB::commit();

            return redirect()->route('purchase-order.index')
                ->with('success', 'Purchase Order berhasil diajukan untuk approval.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal mengajukan Purchase Order: ' . $e->getMessage());
        }
    }

    /**
     * Approve purchase order
     */
    public function approve($id)
    {
        DB::beginTransaction();
        try {
            $purchaseOrder = PurchaseOrder::findOrFail($id);

            if ($purchaseOrder->status !== 'pending') {
                return redirect()->back()
                    ->with('error', 'Hanya Purchase Order dengan status pending yang dapat diapprove.');
            }

            $purchaseOrder->update([
                'status' => 'waiting_goods',
                'approved_by' => Auth::id(),
                'approved_at' => now()
            ]);

            DB::commit();

            return redirect()->back()
                ->with('success', 'Purchase Order berhasil diapprove.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal approve Purchase Order: ' . $e->getMessage());
        }
    }

    /**
     * Reject purchase order
     */
    public function reject($id)
    {
        DB::beginTransaction();
        try {
            $purchaseOrder = PurchaseOrder::findOrFail($id);

            if ($purchaseOrder->status !== 'pending') {
                return redirect()->back()
                    ->with('error', 'Hanya Purchase Order dengan status pending yang dapat direject.');
            }

            $purchaseOrder->update([
                'status' => 'draft',
                'approved_by' => null,
                'approved_at' => null
            ]);

            DB::commit();

            return redirect()->back()
                ->with('success', 'Purchase Order berhasil direject dan dikembalikan ke draft.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal reject Purchase Order: ' . $e->getMessage());
        }
    }

    /**
     * Generate PO Number automatically
     */
    private function generatePONumber()
    {
        $date = date('ym'); // Format: YYMM (contoh: 2510 untuk Oktober 2025)

        // Ambil PO terakhir dengan prefix bulan/tahun yang sama
        $lastPO = PurchaseOrder::where('po_no', 'LIKE', "TGR-PO/MSM/{$date}/%")
            ->orderBy('po_no', 'desc')
            ->first();

        if ($lastPO) {
            // Ambil 4 digit terakhir dan tambah 1
            $lastNumber = (int) substr($lastPO->po_no, -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            // Mulai dari 0001 jika belum ada PO di bulan ini
            $newNumber = '0001';
        }

        return "TGR-PO/MSM/{$date}/{$newNumber}";
    }

    /**
     * Print/Export PDF purchase order
     */
    public function print($id)
    {
        $purchaseOrder = PurchaseOrder::with(['supplier', 'user', 'details.items'])->findOrFail($id);

        // Anda bisa gunakan package seperti DomPDF atau TCPDF
        // return view('purchase-order.print', compact('purchaseOrder'));

        // Atau return PDF
        // $pdf = PDF::loadView('purchase-order.print', compact('purchaseOrder'));
        // return $pdf->download('PO-' . $purchaseOrder->po_no . '.pdf');

        return view('purchase-order.print', compact('purchaseOrder'));
    }
}
