<?php

namespace App\Http\Controllers;

use App\Models\BranchCompany;
use Faker\Core\File;
use Illuminate\Http\Request;
use Spatie\FlareClient\View;
use Illuminate\Support\Facades\Storage;
class BranchCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data['judul'] = 'Branch Company Page';
        $data['data_branch'] = BranchCompany::all();
        return view('branch-company.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        //
        $request->validate([
                'name_branch_company'       => 'required|max:255|min:5',
                'address_branch_company'    => 'required|max:255|min:5',
                'email_branch_company'      => 'required|max:255|min:5',
                'logo'                      => 'required|max:255|min:3',
                'status'                    => 'required|max:20|min:5',
                'phone_number'              => 'required|min:10|max:13'

        ]);

        $logoPath = null;
    if ($request->hasFile('logo')) {
        // Simpan otomatis ke storage/app/public/logos
        $path = $request->file('logo')->store('public/logos');

        // Buat path yang bisa ditampilkan lewat public/storage
        $logoPath = str_replace('public/', 'storage/', $path);
    }

    // 3. Simpan Data ke Database
    BranchCompany::create([
        'name_branch_company'    => $request->name_branch_company,
        'address_branch_company' => $request->address_branch_company,
        'email_branch_company'   => $request->email_branch_company,
        'logo'                   => $logoPath,
        'status'                 => $request->status,
        'phone_number'           => $request->phone_number,
        // Tambahkan kolom lain jika ada
    ]);
    // 4. Redirect dengan Pesan Sukses
    return redirect()->route('branch-company.index')->with('success', 'Data cabang perusahaan berhasil ditambahkan.');

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
   public function edit($id)
{
    $data['judul'] = 'Judul Edit Halaman';
    $data['branchCompanyById'] = BranchCompany::findOrFail($id);

    return view('branch-company.edit', $data);
}


    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, $id)
{
    // 1️⃣ Validasi input
    $request->validate([
        'name_branch_company'    => 'required|max:255|min:5',
        'address_branch_company' => 'required|max:255|min:5',
        'email_branch_company'   => 'required|max:255|min:5',
        'status'                 => 'required|max:20|min:5',
        'phone_number'           => 'required|min:11|max:13',
        'logo'                   => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // logo boleh kosong saat update
    ]);

    // 2️⃣ Ambil data lama dari database
    $branchCompany = BranchCompany::findOrFail($id);

    // 3️⃣ Siapkan path logo lama
    $logoPath = $branchCompany->logo;

    // 4️⃣ Jika user upload logo baru
    if ($request->hasFile('logo')) {
        // Hapus logo lama (jika ada)
        if ($logoPath && file_exists(public_path($logoPath))) {
            unlink(public_path($logoPath));
        }

        // Simpan logo baru
        $path = $request->file('logo')->store('public/logos');
        $logoPath = str_replace('public/', 'storage/', $path);
    }

    // 5️⃣ Update data di database
    $branchCompany->update([
        'name_branch_company'    => $request->name_branch_company,
        'address_branch_company' => $request->address_branch_company,
        'email_branch_company'   => $request->email_branch_company,
        'logo'                   => $logoPath,
        'status'                 => $request->status,
        'phone_number'           => $request->phone_number,
    ]);

    // 6️⃣ Redirect dengan pesan sukses
    return redirect()->route('branch-company.index')
                     ->with('success', 'Data cabang perusahaan berhasil diperbarui.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BranchCompany $branchCompany)
    {
 // Hapus file logo kalau ada
    if ($branchCompany->logo) {
        // Coba hapus dari storage/public
        $storagePath = str_replace('storage/', '', $branchCompany->logo);

        if (Storage::disk('public')->exists($storagePath)) {
            Storage::disk('public')->delete($storagePath);
        }

        // Coba hapus dari public folder langsung (jika file disimpan langsung di public/)
        $publicPath = public_path($branchCompany->logo);
        if (file_exists($publicPath)) {
            unlink($publicPath);
        }
    }

    // Hapus data dari database
    $branchCompany->delete();

    return redirect()->route('branch-company.index')->with('success', 'Data cabang berhasil dihapus.');
    }
}
