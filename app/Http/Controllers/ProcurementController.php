<?php

namespace App\Http\Controllers;

use App\Models\Procurement;
use App\Models\RawMaterial;
use App\Models\SchoolCalendar;
use App\Models\Menu;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProcurementController extends Controller
{
    
    /**
     * Shopping List Calculation (Food)
     */
    public function index(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::tomorrow()->toDateString());
        $endDate = $request->get('end_date', Carbon::tomorrow()->addDays(6)->toDateString());

        // 1. Get total portions per Menu for the date range
        // Only count "receive" status
        $menuPortions = SchoolCalendar::whereBetween('date', [$startDate, $endDate])
            ->where('day_status', 'receive')
            ->select('menu_id', DB::raw('SUM(portion_count) as total_portions'))
            ->groupBy('menu_id')
            ->get();

        // 2. Calculate ingredients needed & Check for unplanned menus
        $ingredients = [];
        $unplannedPortions = 0;
        
        foreach ($menuPortions as $portion) {
            if (!$portion->menu_id) {
                $unplannedPortions += $portion->total_portions;
                continue;
            }

            $menu = Menu::with('menuItems.rawMaterial')->find($portion->menu_id);
            if (!$menu) continue;

            foreach ($menu->menuItems as $item) {
                $rawMaterialId = $item->raw_material_id;
                $needed = $item->quantity_per_portion * $portion->total_portions;

                if (!isset($ingredients[$rawMaterialId])) {
                    $ingredients[$rawMaterialId] = [
                        'raw_material' => $item->rawMaterial,
                        'total_quantity' => 0,
                        'total_cost_estimated' => 0,
                    ];
                }

                $ingredients[$rawMaterialId]['total_quantity'] += $needed;
                $ingredients[$rawMaterialId]['total_cost_estimated'] += $needed * $item->rawMaterial->price_per_unit;
            }
        }

        return view('procurements.shopping-list', compact('ingredients', 'startDate', 'endDate', 'unplannedPortions'));
    }

    /**
     * Office Inventory & Procurement Records
     */
    public function officeInventory()
    {
        $officeItems = RawMaterial::whereHas('category', function($query) {
            $query->where('name', 'Office');
        })->get();
        
        $procurements = Procurement::with('rawMaterial')
            ->latest()
            ->paginate(10);
            
        return view('procurements.office', compact('officeItems', 'procurements'));
    }

    /**
     * Store actual purchase record
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'raw_material_id' => 'required|exists:raw_materials,id',
            'quantity' => 'required|numeric|min:0',
            'price_per_unit' => 'required|numeric|min:0',
        ]);

        $item = RawMaterial::findOrFail($validated['raw_material_id']);
        
        Procurement::create([
            'date' => $validated['date'],
            'raw_material_id' => $validated['raw_material_id'],
            'quantity' => $validated['quantity'],
            'price_per_unit' => $validated['price_per_unit'],
            'total_cost' => $validated['quantity'] * $validated['price_per_unit'],
            'status' => 'purchased',
            'created_by' => auth()->id(),
        ]);

        return back()->with('success', 'Data pembelanjaan berhasil dicatat!');
    }
}
