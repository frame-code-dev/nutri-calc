<?php

namespace App\Http\Controllers;

use App\Models\Kloter;
use App\Models\School;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class KloterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kloters = Kloter::withCount('distributions')->latest()->get();
        return view('kloters.index', compact('kloters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kloters.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'nullable|date',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $kloter = Kloter::create([
            'name' => $validated['name'],
            'date' => $validated['date'] ?? null,
            'description' => $validated['description'] ?? null,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('kloters.index')->with('success', 'Kloter berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kloter $kloter)
    {
        $kloter->load('distributions.school');
        return view('kloters.show', compact('kloter'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kloter $kloter)
    {
        return view('kloters.edit', compact('kloter'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kloter $kloter)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'nullable|date',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $kloter->update([
            'name' => $validated['name'],
            'date' => $validated['date'] ?? null,
            'description' => $validated['description'] ?? null,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('kloters.show', $kloter)->with('success', 'Kloter berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kloter $kloter)
    {
        $kloter->delete();

        return redirect()->route('kloters.index')->with('success', 'Kloter berhasil dihapus!');
    }

    /**
     * Export Kloter to PDF
     */
    public function exportPdf(Kloter $kloter)
    {
        $kloter->load('distributions.school');
        
        $pdf = PDF::loadView('kloters.pdf', compact('kloter'));
        
        return $pdf->download('Kloter_' . $kloter->name . '.pdf');
    }
}
