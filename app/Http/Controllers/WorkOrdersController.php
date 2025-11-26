<?php

namespace App\Http\Controllers;

use App\Models\BillsOfMaterial;
use App\Models\Product;
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
        $data['title_header_dashboard']  = 'Work Orders Page MRP System';
        $data['data_WO'] = WorkOrders::all();
        return view('work-orders.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data['judul'] = 'Laporan Tambah Kerja Page';
        $data['generate_code_work'] = $this->generateCode();
        $data['data_product'] = Product::all();
        $data['data_bom'] = BillsOfMaterial::all();
        return view('work-orders.create',$data);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
        $request->validate([
        'product_id'            => 'required|integer|exists:tb_product,id',
        'bom_id'                => 'required|integer|exists:tb_bills_of_materials,id',
        'no_reference'          => 'required|max:255|min:3',
        'qty_ordered'           => 'required|min:1',
        'qty_completed'         => 'required|min:1',
        'delivery_date_product' => 'required|min:3'
        ]);
        // dd($request);

        WorkOrders::create([
        'work_order_code'       => $this->generateCode(),
        'product_id'            => $request->product_id,
        'bom_id'                => $request->bom_id,
        'no_reference'          => $request->no_reference,
        'qty_ordered'           => $request->qty_ordered,
        'qty_completed'         => $request->qty_completed,
        'delivery_date_product' => $request->delivery_date_product
        ]);
        return redirect()->route('work-orders.index')->with('success', 'Data Daftar Permintaan Pekerjaan berhasil ditambahkan.');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with(['failed' => $th->getMessage(),'scrollTo' => 'step']);
        }

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
