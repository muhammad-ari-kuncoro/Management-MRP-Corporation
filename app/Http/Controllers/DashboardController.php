<?php

namespace App\Http\Controllers;

use App\Models\BranchCompany;
use App\Models\Items;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\WorkOrders;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $data['judul']                  = 'Dashboard Page';
        $data['title_header_dashboard'] = 'Dashboard Page System MRP';
        $data['total_items']            = Items::count();
        $data['totalSupplier']          = Supplier::count();
        $data['totalPO']                = PurchaseOrder::count();
        $data['totalWO']                = WorkOrders::count();
        $data['totalBranch']            = BranchCompany::count();
        $data['recentPO']               = PurchaseOrder::with('supplier')->latest()->take(10)->get();
        $data['recentWorkOrders']       = WorkOrders::with('product')->latest()->take(5)->get();
        // Stok hampir habis
$data['lowStockItems'] = Items::whereColumn('qty', '<=', 'minim_stok')->orderBy('qty', 'asc')->take(8)->get();

                            // PO by status
$data['poByStatus'] = PurchaseOrder::selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status')->toArray();
        return view('dashboard.index',$data);
    }
}
