<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data['product_items'] = Product::all();
        $data['judul'] = 'Product Page';
        return view('product.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data['judul'] = 'Create Product Page';
        return view('product.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
    $data = $request->input('data');

    if (!$data || !is_array($data) || count($data) === 0) {
        return response()->json(['message' => 'Data kosong, tidak ada yang disimpan!'], 422);
    }

    $created = [];

    foreach ($data as $idx => $item) {
        if (empty($item['product_code']) || empty($item['product_name'])) {
            return response()->json([
                'message' => "Item index {$idx} memiliki field kosong (product_code atau product_name)."
            ], 422);
        }

        $created[] = Product::create([
            'product_code'           => $item['product_code'],
            'product_name'           => $item['product_name'],
            'spesification_product'  => $item['spesification_product'] ?? null,
            'type'                   => $item['type'] ?? null,
            'unit'                   => $item['unit'] ?? null,
            'qty_product'            => $item['qty_product'] ?? 0,
            'type_qty'               => $item['type_qty'] ?? null,
            'status'                 => $item['status'] ?? null,
            'description_product'    => $item['description_product'] ?? null,
        ]);
    }

    return response()->json([
        'message' => 'Semua data produk berhasil disimpan!',
        'count'   => count($created)
    ], 200);

} catch (\Throwable $th) {
    return response()->json([
        'message' => 'Terjadi kesalahan saat menyimpan data.',
        'error'   => $th->getMessage()
    ], 500);
}

    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
