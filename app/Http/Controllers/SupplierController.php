<?php

namespace App\Http\Controllers;

use App\Models\BranchCompany;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data['judul'] = 'Master Data Supplier';
        return view('supplier.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data['judul'] = 'Form Master Tambah Data Barang';
        $data['branchCompany'] =  BranchCompany::all();
        return view('supplier.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // 1. VALIDASI DATA
        $validatedData = $request->validate([
            'name_suppliers'      => 'required|string|max:255',
            'nickname_suppliers'  => 'required|string|max:255',
            'type_suppliers'      => 'required|string|max:255',
            'phone_number'        => 'required|string|max:15',
            'email'               => 'required|email|unique:tb_suppliers,email',
            'address'             => 'required|string',
            'address_shipping'    => 'required|string',
            'website'             => 'nullable|url',
            'name_pic'            => 'required|string|max:255',
            'phone_number_pic'    => 'required|string|max:15',
            'id_region'           => 'required|integer|min:1',
            'top'                 => 'required|integer|min:1',
            'limit_kredit'        => 'required|integer|min:0',
            'sales'               => 'required|string|max:255',
            'method_payment'      => 'required|string|max:255',
            'duration_shipping'   => 'required|string|max:255',
            'method_shipping'     => 'required|string|max:255',
            'branch_company_id'   => 'required|exists:tb_branch_company_items,id',
            'brand'               => 'required|string|max:255',
            'bank'                => 'required|string|max:255',
            'no_rek'              => 'required|string|max:30',
            'npwp'                => 'required|string|max:30',
            'siup'                => 'required|string|max:30',
            'scan_npwp'           => 'nullable|max:255|mimes:jpg,jpeg,png,pdf|min:3',
            'scan_siup'           => 'nullable|max:255|mimes:jpg,jpeg,png,pdf|min:3',
        ]);
        dd($validatedData);
        // 2. MENGURUS UPLOAD FILE
        // Menginisialisasi path untuk disimpan ke database
        $npwpPath = null;
        $siupPath = null;

        if ($request->hasFile('scan_npwp')) {
            // Simpan file ke storage (misalnya folder 'public/scans/npwp')
            $npwpPath = $request->file('scan_npwp')->store('scans/npwp', 'public');
        }

        if ($request->hasFile('scan_siup')) {
            // Simpan file ke storage (misalnya folder 'public/scans/siup')
            $siupPath = $request->file('scan_siup')->store('scans/siup', 'public');
        }
        // 3. MEMBUAT DATA SUPPLIER BARU
        try {
            Supplier::create([
                'name_suppliers'      => $validatedData['name_suppliers'],
                'nickname_suppliers'  => $validatedData['nickname_suppliers'],
                'type_suppliers'      => $validatedData['type_suppliers'],
                'phone_number'        => $validatedData['phone_number'],
                'email'               => $validatedData['email'],
                'address'             => $validatedData['address'],
                'address_shipping'    => $validatedData['address_shipping'],
                'website'             => $validatedData['website'] ?? null, // Default null jika tidak diisi
                'name_pic'            => $validatedData['name_pic'],
                'phone_number_pic'    => $validatedData['phone_number_pic'],
                'id_region'           => $validatedData['id_region'],
                'top'                 => $validatedData['top'],
                'limit_kredit'        => $validatedData['limit_kredit'],
                'sales'               => $validatedData['sales'],
                'method_payment'      => $validatedData['method_payment'],
                'duration_shipping'   => $validatedData['duration_shipping'],
                'method_shipping'     => $validatedData['method_shipping'],
                'blacklist'           => 'no', // Default
                'branch_company_id'   => $validatedData['branch_company_id'],
                'brand'               => $validatedData['brand'],
                'bank'                => $validatedData['bank'], // Menggunakan 'bank' sesuai skema migrasi Anda
                'no_rek'              => $validatedData['no_rek'],
                'npwp'                => $validatedData['npwp'],
                'siup'                => $validatedData['siup'],
                'scan_npwp'           => $npwpPath,
                'scan_siup'           => $siupPath,
            ]);

            // 4. REDIRECT DAN PESAN SUKSES
            return redirect()->route('supplier-company.index')->with('success', 'Data Supplier berhasil ditambahkan!');

        } catch (\Exception $e) {
            // Opsional: Log error dan kembalikan pesan gagal
            // Log::error($e->getMessage());
            return back()->withInput()->with('error', 'Gagal menyimpan data supplier. Mohon coba lagi.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        //
    }
}
