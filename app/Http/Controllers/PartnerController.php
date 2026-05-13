<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    // Menampilkan data partner
    public function index()
    {
        $partners = Partner::all();

        return view('admin.partners.index', compact('partners'));
    }

    // Menyimpan data partner baru
    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'name' => 'required',
            'logo_url' => 'required',
        ]);

        // Simpan ke database
        Partner::create([
            'name' => $request->name,
            'logo_url' => $request->logo_url,
        ]);

        // Redirect kembali ke halaman utama
        return redirect('/admin/partners')
            ->with('success', 'Partner berhasil ditambahkan');
    }

    public function create()
    {
        return view('admin.partners.create');
    }
}
