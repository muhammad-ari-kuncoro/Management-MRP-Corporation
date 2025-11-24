<?php

namespace App\Http\Controllers;

use App\Models\WorkOrders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data['judul'] = 'Work Orders Page';
        $data['generate_code_work'] = $this->generateCode();
        return view('work-orders.index',$data);
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
    public function show(WorkOrders $workOrders)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkOrders $workOrders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkOrders $workOrders)
    {
        //
    }
    public function generateCode(){
        $year  = date('Y');
        $month = date('m');

        $count = WorkOrders::whereYear('created_at', $year)->whereMonth('created_at', $month)->count();
        $next = $count + 1;

        return "WO-$year-$month-" . str_pad($next, 4, '0', STR_PAD_LEFT);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkOrders $workOrders)
    {
        //
    }


}
