<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function index()
    {
        $organizations = Organization::with('user')->latest()->paginate(15);
        return view('admin.organizations.index', compact('organizations'));
    }

    public function approve($id)
    {
        $org = Organization::findOrFail($id);
        $org->update(['status' => 'active']);

        return redirect()->route('admin.organizations.index')
            ->with('success', 'Organisasi ' . $org->name . ' telah berhasil disetujui.');
    }

    public function suspend($id)
    {
        $org = Organization::findOrFail($id);
        $org->update(['status' => 'suspended']);

        return redirect()->route('admin.organizations.index')
            ->with('success', 'Organisasi ' . $org->name . ' telah dinonaktifkan sementara.');
    }
}
