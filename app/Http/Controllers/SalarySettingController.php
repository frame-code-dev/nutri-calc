<?php

namespace App\Http\Controllers;

use App\Models\SalarySetting;
use App\Models\MasterSppg;
use Illuminate\Http\Request;

class SalarySettingController extends Controller
{
    public function index()
    {
        $settings = SalarySetting::orderBy('jabatan')->get();
        return view('gaji-relawan.setting', compact('settings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jabatan'      => 'required|string|max:255',
            'upah_per_hari'=> 'required|numeric|min:0',
            'sppg_id'      => 'nullable|exists:master_sppgs,id',
        ]);

        // Upsert: jika jabatan sudah ada, update; jika belum, buat baru
        SalarySetting::updateOrCreate(
            ['jabatan' => $validated['jabatan'], 'sppg_id' => $validated['sppg_id'] ?? null],
            ['upah_per_hari' => $validated['upah_per_hari']]
        );

        return redirect()->route('salary-settings.index')
            ->with('success', 'Setting upah berhasil disimpan.');
    }

    public function update(Request $request, SalarySetting $salarySetting)
    {
        $validated = $request->validate([
            'jabatan'       => 'required|string|max:255',
            'upah_per_hari' => 'required|numeric|min:0',
        ]);

        $salarySetting->update($validated);

        return redirect()->route('salary-settings.index')
            ->with('success', 'Setting upah berhasil diperbarui.');
    }

    public function destroy(SalarySetting $salarySetting)
    {
        $salarySetting->delete();
        return redirect()->route('salary-settings.index')
            ->with('success', 'Setting upah berhasil dihapus.');
    }
}
