<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\RawMaterial;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StockController extends Controller
{
    public function __construct()
    {
        // Middleware handled in routes
    }

    /**
     * Display a listing of stock transactions
     */
    public function index(Request $request)
    {
        $query = Stock::with('rawMaterial', 'supplier', 'creator');

        // Filter by type
        if ($request->has('type') && in_array($request->type, ['in', 'out'])) {
            $query->where('type', $request->type);
        }

        // Filter by raw material
        if ($request->has('raw_material_id')) {
            $query->where('raw_material_id', $request->raw_material_id);
        }

        // Filter by supplier
        if ($request->has('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }

        // Filter by date range
        if ($request->has('start_date')) {
            $query->whereDate('transaction_date', '>=', $request->start_date);
        }
        if ($request->has('end_date')) {
            $query->whereDate('transaction_date', '<=', $request->end_date);
        }

        $stocks = $query->latest('transaction_date')->paginate(20);

        // Get filter options
        $rawMaterials = RawMaterial::where('is_active', true)->orderBy('name')->get();
        $suppliers = Supplier::where('is_active', true)->orderBy('name')->get();

        return view('stocks.index', compact('stocks', 'rawMaterials', 'suppliers'));
    }

    /**
     * Show the form for creating a new stock transaction
     */
    public function create(Request $request)
    {
        $type = $request->get('type', 'in');
        $rawMaterials = RawMaterial::where('is_active', true)->orderBy('name')->get();
        $suppliers = Supplier::where('is_active', true)->orderBy('name')->get();

        return view('stocks.create', compact('type', 'rawMaterials', 'suppliers'));
    }

    /**
     * Store a newly created stock transaction
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'raw_material_id' => 'required|exists:raw_materials,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|numeric|min:0.001',
            'transaction_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        // For stock OUT, check if enough stock available
        if ($validated['type'] === 'out') {
            $material = RawMaterial::find($validated['raw_material_id']);
            $currentStock = $material->getCurrentStock();
            
            if ($currentStock < $validated['quantity']) {
                return back()
                    ->withInput()
                    ->with('error', "Stok tidak cukup! Stok tersedia: {$currentStock} {$material->unit}");
            }
        }

        Stock::create(array_merge(
            $validated,
            ['created_by' => auth()->id()]
        ));

        $type = $validated['type'] === 'in' ? 'masuk' : 'keluar';
        
        return redirect()->route('stocks.index')
            ->with('success', "Transaksi stok {$type} berhasil dicatat!");
    }

    /**
     * Display the specified stock transaction
     */
    public function show(Stock $stock)
    {
        $stock->load('rawMaterial.nutrition', 'supplier', 'creator');
        
        return view('stocks.show', compact('stock'));
    }

    // Removal of edit and update methods as per user request to prevent stock manipulation

    /**
     * Remove the specified stock transaction
     */
    public function destroy(Stock $stock)
    {
        $stock->delete();

        return redirect()->route('stocks.index')
            ->with('success', 'Transaksi stok berhasil dihapus!');
    }

    /**
     * Show stock summary/dashboard
     */
    public function summary()
    {
        $materials = RawMaterial::where('is_active', true)
            ->with('nutrition')
            ->orderBy('name')
            ->get();

        $stockSummary = [];
        foreach ($materials as $material) {
            $currentStock = $material->getCurrentStock();
            
            $stockSummary[] = [
                'material' => $material,
                'current_stock' => $currentStock,
                'unit' => $material->unit,
                'value' => $currentStock * $material->price_per_unit,
                'last_in' => $material->stocks()->where('type', 'in')->latest('transaction_date')->first(),
                'last_out' => $material->stocks()->where('type', 'out')->latest('transaction_date')->first(),
            ];
        }

        return view('stocks.summary', compact('stockSummary'));
    }
}
