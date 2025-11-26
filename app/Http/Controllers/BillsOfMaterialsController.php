<?php

namespace App\Http\Controllers;

use App\Models\BillsOfMaterial;
use App\Models\BillsOfMaterialsDetails;
use App\Models\Items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BillsOfMaterialsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data['judul'] = 'Bills Of Materials Page';
        $data['title_header_dashboard'] = 'Bills Of Materials Page MRP System';
        $data['data_bom'] = BillsOfMaterial::all();
        return view('bills-of-materials.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        // Cari PO dengan status draft milik user aktif
        $bom_draft = BillsOfMaterial::where('user_id', Auth::id())
        ->where('status', 'draft')
        ->first();

        // Jika belum ada draft, buat baru otomatis
        if (!$bom_draft) {
        $bom_draft = BillsOfMaterial::create([
            'user_id' => Auth::id(),
            'code_bom' => 'BOM-' . strtoupper(uniqid()),
            'date_bom' => now(),
            'revision' => 'Revisi 1',
            'status' => 'draft',
        ]);
    }
        // Simpan PO draft ke view
        $data['bom_draft'] = $bom_draft;
        $data['data_items'] = Items::all();

        // Ambil detail barang untuk PO draft
    $data['detail_BOM'] = BillsOfMaterialsDetails::with('items')
        ->where('bom_id', $bom_draft->id)
        ->get();

        $data['judul'] = 'Create Bills of materials Page';
        $data['data_boms'] = BillsOfMaterial::all();
        $data['data_boms_details'] = BillsOfMaterialsDetails::all();
        return view('bills-of-materials.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // 🔹 Validasi input wajib
    $request->validate([
        'date_bom'   => 'required|date',
        'revision'   => 'nullable|string|max:255',
    ]);

    try {
        // 🔹 Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk membuat BOM!');
        }

        // 🔹 Ambil draft BOM milik user yang sedang aktif
        $bomDraft = BillsOfMaterial::where('user_id', Auth::id())
            ->where('status', 'draft')
            ->first();

        // 🔹 Jika belum ada draft, buat baru otomatis
        if (!$bomDraft) {
            $bomDraft = BillsOfMaterial::create([
                'user_id'   => Auth::id(),
                'code_bom'  => $this->generateBOMNumber(),
                'date_bom'  => now(),
                'revision'  => 'Revisi 1',
                'status'    => 'draft',
            ]);
        }

        // 🔹 Pastikan ada detail BOM (barang/material)
        $hasDetails = BillsOfMaterialsDetails::where('bom_id', $bomDraft->id)->exists();
        if (!$hasDetails) {
            return redirect()->back()->with('error', 'Harap tambahkan minimal 1 item sebelum menyimpan!');
        }

        // 🔹 Update data draft ke status Pending
        $bomDraft->update([
            'date_bom'  => $request->date_bom,
            'revision'  => $request->revision ?? 'Revisi 1',
            'code_bom'  => $this->generateBOMNumber(),
            'status'    => 'Pending',
        ]);

        // 🔹 Redirect ke index dengan pesan sukses
        return redirect()
            ->route('bills-of-materials.index')
            ->with([
                'success' => 'Bills of Material berhasil disimpan!',
                'scrollTo' => 'step'
            ]);

    } catch (\Throwable $th) {
        return redirect()
            ->back()
            ->with([
                'failed' => 'Terjadi kesalahan: ' . $th->getMessage(),
                'scrollTo' => 'step'
            ]);
    }
}

    public function storeDetailBOM(Request $request)
    {

    //
        $request->validate([
            'date_bom' => 'nullable',
            'revision' => 'nullable',
            'status' => 'draft',

        ]);

        try {
    $billsOfMaterial = BillsOfMaterial::where('user_id', Auth::id())
        ->where('status', 'draft')
        ->latest()
        ->first();

        if (!$billsOfMaterial) {
            $billsOfMaterial = BillsOfMaterial::create([

            'code_bom'      =>  'BOM-' . now()->format('Ymd'),
            'user_id'       =>  Auth::id(),
            'date_bom'      =>  now(),
            'revision'      => 'NO REVISION',
            'status'        => 'draft'
        ]);
        }
        $item = Items::findOrFail($request->item_id);

        BillsOfMaterialsDetails::create([
            'bom_id'        => $billsOfMaterial->id,
            'item_id'       => $item->id,
            'plan_qty'      => $request->plan_qty,
            'notes'         => $request->notes,
        ]);
        return redirect()->back()->with(['success' => 'Update Sukses!', 'scrollTo' => 'step']);
        } catch (\Throwable $th) {
            //throw $th;
        return redirect()->back()->with(['failed'=> $th->getMessage(), 'scrollTo' => 'step']);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(BillsOfMaterial $billsOfMaterial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BillsOfMaterial $billsOfMaterial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BillsOfMaterial $billsOfMaterial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $detail = BillsOfMaterialsDetails::findOrFail($id);

            // Cek status PO
            $billsOfMaterial = BillsOfMaterial::findOrFail($detail->bom_id);
            if ($billsOfMaterial->status !== 'draft') {
                return redirect()->back()
                    ->with('error', 'Bills Of Materials sudah diajukan, tidak dapat menghapus item.');
            }
            $detail->delete();
            DB::commit();
            return redirect()->back()
                ->with('success', 'Item berhasil dihapus dari Bills Of Materials.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menghapus item: ' . $e->getMessage());
        }
    }


     private function generateBOMNumber()
    {
        $date = date('ym'); // Format: YYMM (contoh: 2510 untuk Oktober 2025)

        // Ambil PO terakhir dengan prefix bulan/tahun yang sama
        $lastBOM = BillsOfMaterial::where('code_bom', 'LIKE', "TGR-BOM/ITM/{$date}/%")
            ->orderBy('code_bom', 'desc')
            ->first();

        if ($lastBOM) {
            // Ambil 4 digit terakhir dan tambah 1
            $lastNumber = (int) substr($lastBOM->code_bom, -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            // Mulai dari 0001 jika belum ada PO di bulan ini
            $newNumber = '0001';
        }

        return "TGR-BOM/ITM/{$date}/{$newNumber}";
    }
}
