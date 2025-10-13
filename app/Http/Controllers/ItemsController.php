<?php

namespace App\Http\Controllers;

use App\Models\BranchCompany;
use App\Models\Items;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data['judul'] = 'Master Data Barang';
        $data['item_all'] = Items::all();
        return view('items.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data['branch_company'] = BranchCompany::all();
        return view('items.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->input('data');

        if (!$data || !is_array($data) || count($data) === 0) {
            return response()->json(['message' => 'Data kosong, tidak ada yang disimpan!'], 422);
        }

        $created = [];
        foreach ($data as $idx => $item) {
            // optional: basic validation per item (bisa ditingkatkan)
            if (empty($item['kode']) || empty($item['nama'])) {
                return response()->json([
                    'message' => "Item index {$idx} memiliki field kosong."
                ], 422);
            }

            $created[] = Items::create([
                'kd_item' => $item['kode'],
                'name_item' => $item['nama'],
                'spesification' => $item['spesification'],
                'type' => $item['type'],
                'price_item' => $item['price_item'],
                'qty' => $item['qty'],
                'weight_item' => $item['weight_item'],
                'hpp' => $item['hpp'],
                'category' => $item['category'],
                'status_item' => $item['status_item'],
                'branch_company_id' => $item['branch_company_id'],
                'minim_stok' => $item['minim_stok'],
                'konversion_items_carbon' => $item['konversion_items_carbon'],
                'description' => $item['description'] ?? null,
            ]);
        }

        return response()->json(['message' => 'Semua data barang berhasil disimpan!', 'count' => count($created)]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Items $items)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Items $items)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Items $items)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Items $items)
    {
        //
    }
}
