<?php

namespace App\Http\Controllers;

use App\Models\Relawan;
use App\Models\MasterSppg;
use Illuminate\Http\Request;

class RelawanController extends Controller
{
    public function index()
    {
        $relawans = Relawan::with('sppg')
            ->orderBy('tipe')
            ->orderBy('nomor_urut')
            ->orderBy('nama')
            ->get();

        $tetap  = $relawans->where('tipe', 'tetap');
        $magang = $relawans->where('tipe', 'magang');

        return view('relawans.index', compact('relawans', 'tetap', 'magang'));
    }

    public function create()
    {
        $sppgs = MasterSppg::all();
        return view('relawans.create', compact('sppgs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sppg_id'     => 'nullable|exists:master_sppgs,id',
            'nama'        => 'required|string|max:255',
            'jabatan'     => 'required|string|max:255',
            'tipe'        => 'required|in:tetap,magang',
            'nomor_urut'  => 'required|integer|min:1',
            'aktif'       => 'boolean',
        ]);

        $validated['aktif'] = $request->boolean('aktif', true);

        Relawan::create($validated);

        return redirect()->route('relawans.index')
            ->with('success', 'Data relawan berhasil ditambahkan.');
    }

    public function edit(Relawan $relawan)
    {
        $sppgs = MasterSppg::all();
        return view('relawans.edit', compact('relawan', 'sppgs'));
    }

    public function update(Request $request, Relawan $relawan)
    {
        $validated = $request->validate([
            'sppg_id'    => 'nullable|exists:master_sppgs,id',
            'nama'       => 'required|string|max:255',
            'jabatan'    => 'required|string|max:255',
            'tipe'       => 'required|in:tetap,magang',
            'nomor_urut' => 'required|integer|min:1',
            'aktif'      => 'boolean',
        ]);

        $validated['aktif'] = $request->boolean('aktif', true);

        $relawan->update($validated);

        return redirect()->route('relawans.index')
            ->with('success', 'Data relawan berhasil diperbarui.');
    }

    public function destroy(Relawan $relawan)
    {
        $relawan->delete();
        return redirect()->route('relawans.index')
            ->with('success', 'Data relawan berhasil dihapus.');
    }
}
