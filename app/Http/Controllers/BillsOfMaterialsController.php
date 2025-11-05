<?php

namespace App\Http\Controllers;

use App\Models\BillsOfMaterial;
use App\Models\BillsOfMaterialsDetails;
use App\Models\Items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillsOfMaterialsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data['judul'] = 'Bills Of Materials Page';
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
            'code_bom' => 'PO-' . strtoupper(uniqid()),
            'date_bom' => now(),
            'revision' => 'Revisi 1',
            'status' => 'draft',
        ]);
    }
        // Simpan PO draft ke view
        $data['bom_draft'] = $bom_draft;
        $data['data_items'] = Items::all();

        // Ambil detail barang untuk PO draft
    $data['detail_po'] = BillsOfMaterialsDetails::with('items')
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
        //
    }

    public function storeDetailBOM (Request $request)
    {

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
    public function destroy(BillsOfMaterial $billsOfMaterial)
    {
        //
    }
}
