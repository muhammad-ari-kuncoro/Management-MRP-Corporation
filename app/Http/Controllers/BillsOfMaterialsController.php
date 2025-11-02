<?php

namespace App\Http\Controllers;

use App\Models\BillsOfMaterial;
use Illuminate\Http\Request;

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
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
