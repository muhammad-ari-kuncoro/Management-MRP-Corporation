<?php

namespace App\Http\Controllers;

use App\Models\BranchCompany;
use Illuminate\Http\Request;
use Spatie\FlareClient\View;

class BranchCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data['judul'] = 'Branch Company Page';
        $data['data-branch'] = BranchCompany::all();
        return view('branch-company.index',$data);
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
    public function show(BranchCompany $branchCompany)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BranchCompany $branchCompany)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BranchCompany $branchCompany)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BranchCompany $branchCompany)
    {
        //
    }
}
