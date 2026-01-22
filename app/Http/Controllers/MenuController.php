<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\RawMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function __construct()
    {
        // Middleware handled in routes
    }

    /**
     * Display a listing of menus
     */
    public function index(Request $request)
    {
        $query = Menu::with('menuItems.rawMaterial');

        // Filter by category (Tab)
        // Default to 'master' if not specified
        $category = $request->get('category', 'master');
        $query->where('category', $category);

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by type
        if ($request->has('type') && in_array($request->type, ['wet', 'dry'])) {
            $query->where('type', $request->type);
        }

        $menus = $query->latest()->paginate(20);

        return view('menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new menu
     */
    public function create()
    {
        $rawMaterials = RawMaterial::where('is_active', true)
            ->with('nutrition')
            ->orderBy('name')
            ->get();
        
        $categories = \App\Models\Category::orderBy('name')->get();
        
        return view('menus.create', compact('rawMaterials', 'categories'));
    }

    /**
     * Store a newly created menu
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:wet,dry',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'items' => 'required|array|min:1',
            'items.*.group_name' => 'nullable|string|max:255',
            'items.*.raw_material_id' => 'required|exists:raw_materials,id',
            'items.*.quantity_per_portion' => 'required|numeric|min:0.001',
        ]);

        DB::beginTransaction();
        try {
            // Create menu
            $menu = Menu::create([
                'name' => $validated['name'],
                'type' => $validated['type'],
                'description' => $validated['description'] ?? null,
                'is_active' => $request->has('is_active'),
            ]);

            // Create menu items
            foreach ($validated['items'] as $item) {
                MenuItem::create([
                    'menu_id' => $menu->id,
                    'group_name' => $item['group_name'] ?? null,
                    'raw_material_id' => $item['raw_material_id'],
                    'quantity_per_portion' => $item['quantity_per_portion'],
                ]);
            }

            DB::commit();

            return redirect()->route('menus.show', $menu)
                ->with('success', 'Menu berhasil ditambahkan dengan ' . count($validated['items']) . ' bahan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan menu: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified menu with nutrition calculation
     */
    public function show(Menu $menu)
    {
        $menu->load('menuItems.rawMaterial.nutrition');

        // Calculate nutrition automatically
        $nutritionData = $menu->calculateNutrition();

        return view('menus.show', compact('menu', 'nutritionData'));
    }

    /**
     * Show the form for editing the specified menu
     */
    public function edit(Menu $menu)
    {
        $menu->load('menuItems.rawMaterial');
        $rawMaterials = RawMaterial::where('is_active', true)
            ->with('nutrition')
            ->orderBy('name')
            ->get();
        
        $categories = \App\Models\Category::orderBy('name')->get();
        
        return view('menus.edit', compact('menu', 'rawMaterials', 'categories'));
    }

    /**
     * Update the specified menu
     */
    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:wet,dry',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'items' => 'required|array|min:1',
            'items.*.group_name' => 'nullable|string|max:255',
            'items.*.raw_material_id' => 'required|exists:raw_materials,id',
            'items.*.quantity_per_portion' => 'required|numeric|min:0.001',
        ]);

        DB::beginTransaction();
        try {
            // Check if menu is used in Calendars or Schedules
            $isUsed = $menu->calendars()->exists() || $menu->schedules()->exists();

            if ($isUsed) {
                // Versioning Logic: Create NEW menu
                $newVersion = $menu->version + 1;
                $newMenu = Menu::create([
                    'name' => $validated['name'], // Same name or potentially modified
                    'type' => $validated['type'],
                    'description' => $validated['description'] ?? null,
                    'is_active' => $request->has('is_active'),
                    'parent_id' => $menu->parent_id ?? $menu->id, // If it was already a child, keep same parent
                    'version' => $newVersion,
                    'code' => $menu->code ?? \Illuminate\Support\Str::slug($menu->name) . '-' . uniqid(),
                ]);

                // Create items for new menu
                foreach ($validated['items'] as $item) {
                    MenuItem::create([
                        'menu_id' => $newMenu->id,
                        'group_name' => $item['group_name'] ?? null,
                        'raw_material_id' => $item['raw_material_id'],
                        'quantity_per_portion' => $item['quantity_per_portion'],
                    ]);
                }
                
                // Old menu remains as is (Serve as history)

                DB::commit();

                // Recalculate nutrition for new menu
                $nutritionData = $newMenu->calculateNutrition();

                return redirect()->route('menus.show', $newMenu)
                    ->with('success', "Menu versi baru (v{$newVersion}) berhasil dibuat! Menu lama disimpan sebagai riwayat.");

            } else {
                // Not used, safe to update directly
                $menu->update([
                    'name' => $validated['name'],
                    'type' => $validated['type'],
                    'description' => $validated['description'] ?? null,
                    'is_active' => $request->has('is_active'),
                    'code' => $menu->code ?? \Illuminate\Support\Str::slug($validated['name']) . '-' . uniqid(),
                ]);

                // Delete old items and create new ones
                $menu->menuItems()->delete();

                foreach ($validated['items'] as $item) {
                    MenuItem::create([
                        'menu_id' => $menu->id,
                        'group_name' => $item['group_name'] ?? null,
                        'raw_material_id' => $item['raw_material_id'],
                        'quantity_per_portion' => $item['quantity_per_portion'],
                    ]);
                }

                DB::commit();

                // Recalculate nutrition
                $nutritionData = $menu->fresh()->calculateNutrition();

                return redirect()->route('menus.show', $menu)
                    ->with('success', 'Menu berhasil diperbarui! Gizi: ' . number_format($nutritionData['energy'], 0) . ' kkal');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memperbarui menu: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified menu
     */
    public function destroy(Menu $menu)
    {
        // Check if menu is used in calendars
        $usedInCalendars = $menu->calendars()->count();
        
        if ($usedInCalendars > 0) {
            return back()->with('error', "Menu tidak dapat dihapus karena sudah digunakan di {$usedInCalendars} jadwal!");
        }

        $menu->delete();

        return redirect()->route('menus.index')
            ->with('success', 'Menu berhasil dihapus!');
    }

    /**
     * Toggle menu active status
     */
    public function toggleStatus(Menu $menu)
    {
        $menu->update(['is_active' => !$menu->is_active]);
        
        $status = $menu->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return back()->with('success', "Menu berhasil {$status}!");
    }
}
