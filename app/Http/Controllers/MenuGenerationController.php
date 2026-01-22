<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuGenerationController extends Controller
{
    /**
     * Show the generation form.
     */
    public function index()
    {
        // Get all "Master Menus"
        // In reality, any menu can be a master, but we might filter by some criteria if needed.
        // For now, list all active menus.
        $menus = \App\Models\Menu::where('is_active', true)
                 ->orderBy('name')
                 ->get();
                 
        return view('menus.generate', compact('menus'));
    }

    /**
     * Store the generated menu.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'menu_ids' => 'required|array|min:1',
            'menu_ids.*' => 'exists:menus,id',
            'description' => 'nullable|string',
        ]);

        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            // Create the new Daily/Paket Menu
            $newMenu = \App\Models\Menu::create([
                'name' => $validated['name'],
                'type' => 'wet', // Default to wet
                'category' => 'packet', // Marked as generated packet
                'description' => $validated['description'] ?? 'Generated from Master Menus',
                'is_active' => true,
            ]);

            // Iterate selected master menus
            $selectedMenus = \App\Models\Menu::whereIn('id', $validated['menu_ids'])->get();

            foreach ($selectedMenus as $masterMenu) {
                // Get items from master menu
                $items = $masterMenu->menuItems()->with('rawMaterial')->get();

                foreach ($items as $item) {
                    \App\Models\MenuItem::create([
                        'menu_id' => $newMenu->id,
                        'raw_material_id' => $item->raw_material_id,
                        'quantity_per_portion' => $item->quantity_per_portion,
                        // Crucial: Set group_name to the Master Menu's name
                        // This segments the new menu into blocks like "Nasi Putih", "Ayam Teriyaki"
                        'group_name' => $masterMenu->name, 
                    ]);
                }
            }

            \Illuminate\Support\Facades\DB::commit();

            return redirect()->route('menus.show', $newMenu)
                ->with('success', 'Menu Paket berhasil dibuat!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return back()->withInput()->with('error', 'Gagal membuat menu: ' . $e->getMessage());
            }
    }
}
