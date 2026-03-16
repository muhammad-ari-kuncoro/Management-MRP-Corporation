<?php

namespace App\Http\Controllers;

use App\Exports\BranchCompanyExport;
use App\Exports\SupplierExport;
use App\Models\BranchCompany;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data['judul'] = 'Master Data Supplier';
        $data['title_header_dashboard'] = 'Supplier Company Page MRP System';
        $data['data_supplier']  = Supplier::all();
        return view('supplier.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data['judul'] = 'Form Master Tambah Data Barang';
        $data['title_header_dashboard'] = 'Create Data Supplier Company MRP System';
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
            'scan_siup'           => 'nullable|max:255|min:10',
            'scan_npwp'           => 'nullable|max:255|min:10'

        ]);
        // dd($request->all());
        $scanNPWPPath = null;
        $scanSIUP = null;
        if ($request->hasFile('scan_npwp')) {
            $path = $request->file('scan_npwp')->store('scans/npwp', 'public');
            $scanNPWPPath = str_replace('public/', 'storage/', $path);
            // dd('NPWP tersimpan di:', $scanNPWPPath);
        }

        if ($request->hasFile('scan_siup')) {
            $path = $request->file('scan_siup')->store('scans/siup', 'public');
            $scanSIUP = str_replace('public/', 'storage/', $path);
            // dd('NPWP tersimpan di:', $scanSIUP);
        }

        // if ($request->hasFile('scan_siup')) {
        //     $path = $request->file('scan_siup')->store('scans/siup', 'public');
        //     $scanSIUP = str_replace('public/', 'storage/', $path);
        // }

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
                'website'             => $validatedData['website'] ?? null,
                'name_pic'            => $validatedData['name_pic'],
                'phone_number_pic'    => $validatedData['phone_number_pic'],
                'id_region'           => $validatedData['id_region'],
                'top'                 => $validatedData['top'],
                'limit_kredit'        => $validatedData['limit_kredit'],
                'sales'               => $validatedData['sales'],
                'method_payment'      => $validatedData['method_payment'],
                'duration_shipping'   => $validatedData['duration_shipping'],
                'method_shipping'     => $validatedData['method_shipping'],
                'blacklist'           => 'no',
                'branch_company_id'   => $validatedData['branch_company_id'],
                'brand'               => $validatedData['brand'],
                'bank'                => $validatedData['bank'],
                'no_rek'              => $validatedData['no_rek'],
                'npwp'                => $validatedData['npwp'],
                'siup'                => $validatedData['siup'],
                'scan_npwp'           => $scanNPWPPath,
                'scan_siup'           => $scanSIUP,
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
    public function edit($id)
    {
        //
        $data['judul'] = 'Halaman Edit Supplier';
        $data['title_header_dashboard'] = 'Edit Data Supplier Company MRP System';
        $data['dataSupplierById'] = Supplier::findOrFail($id);
        $data['branchCompany'] = BranchCompany::all();
        return view('supplier.edit',$data);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // 1. Ambil data supplier berdasarkan ID
        $supplier = Supplier::findOrFail($id);

        // 2. VALIDASI DATA
        $validatedData = $request->validate([
            'name_suppliers'      => 'required|string|max:255',
            'nickname_suppliers'  => 'required|string|max:255',
            'type_suppliers'      => 'required|string|max:255',
            'phone_number'        => 'required|string|max:15',
            'email'               => 'required|email|unique:tb_suppliers,email,' . $supplier->id,
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
            'scan_siup'           => 'nullable|file|max:2048',
            'scan_npwp'           => 'nullable|file|max:2048',
            ]);

            try {
        // 3. HANDLE FILE UPLOAD (jika ada file baru)
        $scanNPWPPath = $supplier->scan_npwp;
        $scanSIUPPath = $supplier->scan_siup;

        if ($request->hasFile('scan_npwp')) {
    // Hapus file lama kalau ada
    if ($supplier->scan_npwp) {
        Storage::disk('public')->delete(
            str_replace('storage/', '', $supplier->scan_npwp)
        );
    }

    $path = $request->file('scan_npwp')->store('scans/npwp', 'public');
    // path yang disimpan ke DB: 'storage/scans/npwp/xxx.png'
    $scanNPWPPath = 'storage/' . $path;
}

if ($request->hasFile('scan_siup')) {
    if ($supplier->scan_siup) {
        Storage::disk('public')->delete(
            str_replace('storage/', '', $supplier->scan_siup)
        );
    }

    $path = $request->file('scan_siup')->store('scans/siup', 'public');
    $scanSIUPPath = 'storage/' . $path;
}


        // 4. UPDATE DATA SUPPLIER
            $supplier->update([
                'name_suppliers'      => $validatedData['name_suppliers'],
                'nickname_suppliers'  => $validatedData['nickname_suppliers'],
                'type_suppliers'      => $validatedData['type_suppliers'],
                'phone_number'        => $validatedData['phone_number'],
                'email'               => $validatedData['email'],
                'address'             => $validatedData['address'],
                'address_shipping'    => $validatedData['address_shipping'],
                'website'             => $validatedData['website'] ?? null,
                'name_pic'            => $validatedData['name_pic'],
                'phone_number_pic'    => $validatedData['phone_number_pic'],
                'id_region'           => $validatedData['id_region'],
                'top'                 => $validatedData['top'],
                'limit_kredit'        => $validatedData['limit_kredit'],
                'sales'               => $validatedData['sales'],
                'method_payment'      => $validatedData['method_payment'],
                'duration_shipping'   => $validatedData['duration_shipping'],
                'method_shipping'     => $validatedData['method_shipping'],
                'branch_company_id'   => $validatedData['branch_company_id'],
                'brand'               => $validatedData['brand'],
                'bank'                => $validatedData['bank'],
                'no_rek'              => $validatedData['no_rek'],
                'npwp'                => $validatedData['npwp'],
                'siup'                => $validatedData['siup'],
                'scan_npwp'           => $scanNPWPPath,
                'scan_siup'           => $scanSIUPPath,
            ]);

            return redirect()->route('supplier-company.index')->with('success', 'Data Supplier berhasil diperbarui!');
        } catch (\Exception $e) {
            // Log::error($e->getMessage());
            return back()->withInput()->with('error', 'Gagal memperbarui data supplier. Mohon coba lagi.');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
            try {
            // 1. Cari data supplier
            $supplier = Supplier::findOrFail($id);

            // 2. Hapus file gambar (jika ada)
            if ($supplier->scan_npwp && file_exists(public_path($supplier->scan_npwp))) {
                unlink(public_path($supplier->scan_npwp));
            }

            if ($supplier->scan_siup && file_exists(public_path($supplier->scan_siup))) {
                unlink(public_path($supplier->scan_siup));
            }
            // 3. Soft delete data
            $supplier->delete();
            // 4. Redirect ke halaman index
            return redirect()->route('supplier-company.index')
                ->with('success', 'Data Supplier berhasil dihapus (soft delete) dan file terkait sudah dihapus.');

        } catch (\Exception $e) {
            // 5. Tangani jika error
            return redirect()->route('supplier-company.index')
                ->with('error', 'Gagal menghapus data Supplier. Mohon coba lagi.');
        }
    }
    public function exportExcel (Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $namaBulan = Carbon::create()->month($bulan)->format('F');
        $filename = "Supplier-Company-{$namaBulan}-{$tahun}.xlsx";

        return Excel::download(new SupplierExport($bulan, $tahun), $filename);
    }
}
