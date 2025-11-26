<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $data['judul'] = 'Dashboard Page';
        $data['title_header_dashboard'] = 'Dashboard Page System MRP';
        return view('dashboard.index',$data);
    }
}
