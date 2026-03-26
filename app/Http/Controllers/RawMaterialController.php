<?php

namespace App\Http\Controllers;

use App\Models\RawMaterial;
use App\Models\RawMaterialNutrition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RawMaterialController extends Controller
{
    public function __construct()
    {
        // Middleware handled in routes
    }

    /**
     * Display a listing of raw materials
     */
    public function index(Request $request)
    {
        $query = RawMaterial::with('nutrition', 'category');

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->when($search, function ($query) use ($search) {
                $query->where('name', 'ILIKE', '%' . $search . '%');
            });
        }

        // Filter by category
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $isActive = $request->status === 'active';
            $query->where('is_active', $isActive);
        }

        $materials = $query->latest()->paginate(15);
        $categories = \App\Models\Category::all();

        // Get current stock for each material
        foreach ($materials as $material) {
            $material->current_stock = $material->getCurrentStock();
        }

        return view('raw-materials.index', compact('materials', 'categories'));
    }

    /**
     * Show the form for creating a new raw material
     */
    public function create()
    {
        $categories = \App\Models\Category::all();
        $foodCategoryId = $categories->where('name', 'Food')->first()?->id;
        return view('raw-materials.create', compact('categories', 'foodCategoryId'));
    }

    /**
     * Store a newly created raw material
     */
    public function store(Request $request)
    {
        $foodCategory = \App\Models\Category::where('name', 'Food')->first();
        $isFood = $foodCategory && $request->category_id == $foodCategory->id;

        $rules = [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'unit' => 'required|string|max:50',
            'price_per_unit' => 'required|numeric|min:0',
            'code' => 'nullable|string|max:50', // Added code validation
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ];

        if ($isFood) {
            $rules = array_merge($rules, [
                // Proximate
                'water_per_100g'         => 'nullable|numeric|min:0',
                'energy_per_100g'        => 'required|numeric|min:0',
                'protein_per_100g'       => 'required|numeric|min:0',
                'fat_per_100g'           => 'required|numeric|min:0',
                'carbohydrate_per_100g'  => 'required|numeric|min:0',
                'fiber_per_100g'         => 'required|numeric|min:0',
                'ash_per_100g'           => 'nullable|numeric|min:0',
                // Minerals
                'calcium_per_100g'       => 'nullable|numeric|min:0',
                'phosphorus_per_100g'    => 'nullable|numeric|min:0',
                'iron_per_100g'          => 'nullable|numeric|min:0',
                'sodium_per_100g'        => 'nullable|numeric|min:0',
                'potassium_per_100g'     => 'nullable|numeric|min:0',
                'copper_per_100g'        => 'nullable|numeric|min:0',
                'zinc_per_100g'          => 'nullable|numeric|min:0',
                // Vitamins
                'retinol_per_100g'       => 'nullable|numeric|min:0',
                'beta_carotene_per_100g' => 'nullable|numeric|min:0',
                'carotene_per_100g'      => 'nullable|numeric|min:0',
                'thiamine_per_100g'      => 'nullable|numeric|min:0',
                'riboflavin_per_100g'    => 'nullable|numeric|min:0',
                'niacin_per_100g'        => 'nullable|numeric|min:0',
                'vitamin_c_per_100g'     => 'nullable|numeric|min:0',
                // BDD
                'bdd'                    => 'nullable|numeric|min:0|max:100',
            ]);
        }

        $validated = $request->validate($rules);

        DB::transaction(function () use ($validated, $isFood) {
            $material = RawMaterial::create([
                'name' => $validated['name'],
                'category_id' => $validated['category_id'],
                'unit' => $validated['unit'],
                'price_per_unit' => $validated['price_per_unit'],
                'code' => $validated['code'] ?? null, // Added code
                'description' => $validated['description'] ?? null,
                'is_active' => $validated['is_active'] ?? true,
            ]);

            if ($isFood) {
                RawMaterialNutrition::create([
                    'raw_material_id'        => $material->id,
                    'water_per_100g'         => $validated['water_per_100g'] ?? 0,
                    'energy_per_100g'        => $validated['energy_per_100g'],
                    'protein_per_100g'       => $validated['protein_per_100g'],
                    'fat_per_100g'           => $validated['fat_per_100g'],
                    'carbohydrate_per_100g'  => $validated['carbohydrate_per_100g'],
                    'fiber_per_100g'         => $validated['fiber_per_100g'],
                    'ash_per_100g'           => $validated['ash_per_100g'] ?? 0,
                    'calcium_per_100g'       => $validated['calcium_per_100g'] ?? 0,
                    'phosphorus_per_100g'    => $validated['phosphorus_per_100g'] ?? 0,
                    'iron_per_100g'          => $validated['iron_per_100g'] ?? 0,
                    'sodium_per_100g'        => $validated['sodium_per_100g'] ?? 0,
                    'potassium_per_100g'     => $validated['potassium_per_100g'] ?? 0,
                    'copper_per_100g'        => $validated['copper_per_100g'] ?? 0,
                    'zinc_per_100g'          => $validated['zinc_per_100g'] ?? 0,
                    'retinol_per_100g'       => $validated['retinol_per_100g'] ?? 0,
                    'beta_carotene_per_100g' => $validated['beta_carotene_per_100g'] ?? 0,
                    'carotene_per_100g'      => $validated['carotene_per_100g'] ?? 0,
                    'thiamine_per_100g'      => $validated['thiamine_per_100g'] ?? 0,
                    'riboflavin_per_100g'    => $validated['riboflavin_per_100g'] ?? 0,
                    'niacin_per_100g'        => $validated['niacin_per_100g'] ?? 0,
                    'vitamin_c_per_100g'     => $validated['vitamin_c_per_100g'] ?? 0,
                    'bdd'                    => $validated['bdd'] ?? 100,
                ]);
            }
        });

        return redirect()->route('raw-materials.index')
            ->with('success', 'Bahan baku berhasil ditambahkan!');
    }

    /**
     * Display the specified raw material
     */
    public function show(RawMaterial $rawMaterial)
    {
        $rawMaterial->load('nutrition', 'category', 'stocks.supplier', 'menuItems.menu');
        $rawMaterial->current_stock = $rawMaterial->getCurrentStock();

        // Get recent stock transactions
        $recentStocks = $rawMaterial->stocks()
            ->with('supplier', 'creator')
            ->latest('transaction_date')
            ->limit(10)
            ->get();

        return view('raw-materials.show', compact('rawMaterial', 'recentStocks'));
    }

    /**
     * Show the form for editing the specified raw material
     */
    public function edit(RawMaterial $rawMaterial)
    {
        $rawMaterial->load('nutrition', 'category');
        $categories = \App\Models\Category::all();
        $foodCategoryId = $categories->where('name', 'Food')->first()?->id;
        return view('raw-materials.edit', compact('rawMaterial', 'categories', 'foodCategoryId'));
    }

    /**
     * Update the specified raw material
     */
    public function update(Request $request, RawMaterial $rawMaterial)
    {
        $foodCategory = \App\Models\Category::where('name', 'Food')->first();
        $isFood = $foodCategory && $request->category_id == $foodCategory->id;

        $rules = [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'unit' => 'required|string|max:50',
            'price_per_unit' => 'required|numeric|min:0',
            'code' => 'nullable|string|max:50', // Added code validation
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ];

        if ($isFood) {
            $rules = array_merge($rules, [
                // Proximate
                'water_per_100g'         => 'nullable|numeric|min:0',
                'energy_per_100g'        => 'required|numeric|min:0',
                'protein_per_100g'       => 'required|numeric|min:0',
                'fat_per_100g'           => 'required|numeric|min:0',
                'carbohydrate_per_100g'  => 'required|numeric|min:0',
                'fiber_per_100g'         => 'required|numeric|min:0',
                'ash_per_100g'           => 'nullable|numeric|min:0',
                // Minerals
                'calcium_per_100g'       => 'nullable|numeric|min:0',
                'phosphorus_per_100g'    => 'nullable|numeric|min:0',
                'iron_per_100g'          => 'nullable|numeric|min:0',
                'sodium_per_100g'        => 'nullable|numeric|min:0',
                'potassium_per_100g'     => 'nullable|numeric|min:0',
                'copper_per_100g'        => 'nullable|numeric|min:0',
                'zinc_per_100g'          => 'nullable|numeric|min:0',
                // Vitamins
                'retinol_per_100g'       => 'nullable|numeric|min:0',
                'beta_carotene_per_100g' => 'nullable|numeric|min:0',
                'carotene_per_100g'      => 'nullable|numeric|min:0',
                'thiamine_per_100g'      => 'nullable|numeric|min:0',
                'riboflavin_per_100g'    => 'nullable|numeric|min:0',
                'niacin_per_100g'        => 'nullable|numeric|min:0',
                'vitamin_c_per_100g'     => 'nullable|numeric|min:0',
                // BDD
                'bdd'                    => 'nullable|numeric|min:0|max:100',
            ]);
        }

        $validated = $request->validate($rules);

        DB::transaction(function () use ($validated, $rawMaterial, $isFood) {
            $rawMaterial->update([
                'name' => $validated['name'],
                'category_id' => $validated['category_id'],
                'unit' => $validated['unit'],
                'price_per_unit' => $validated['price_per_unit'],
                'code' => $validated['code'] ?? null, // Added code
                'description' => $validated['description'] ?? null,
                'is_active' => $validated['is_active'] ?? true,
            ]);

            if ($isFood) {
                $rawMaterial->nutrition()->updateOrCreate(
                    ['raw_material_id' => $rawMaterial->id],
                    [
                        'water_per_100g'         => $validated['water_per_100g'] ?? 0,
                        'energy_per_100g'        => $validated['energy_per_100g'],
                        'protein_per_100g'       => $validated['protein_per_100g'],
                        'fat_per_100g'           => $validated['fat_per_100g'],
                        'carbohydrate_per_100g'  => $validated['carbohydrate_per_100g'],
                        'fiber_per_100g'         => $validated['fiber_per_100g'],
                        'ash_per_100g'           => $validated['ash_per_100g'] ?? 0,
                        'calcium_per_100g'       => $validated['calcium_per_100g'] ?? 0,
                        'phosphorus_per_100g'    => $validated['phosphorus_per_100g'] ?? 0,
                        'iron_per_100g'          => $validated['iron_per_100g'] ?? 0,
                        'sodium_per_100g'        => $validated['sodium_per_100g'] ?? 0,
                        'potassium_per_100g'     => $validated['potassium_per_100g'] ?? 0,
                        'copper_per_100g'        => $validated['copper_per_100g'] ?? 0,
                        'zinc_per_100g'          => $validated['zinc_per_100g'] ?? 0,
                        'retinol_per_100g'       => $validated['retinol_per_100g'] ?? 0,
                        'beta_carotene_per_100g' => $validated['beta_carotene_per_100g'] ?? 0,
                        'carotene_per_100g'      => $validated['carotene_per_100g'] ?? 0,
                        'thiamine_per_100g'      => $validated['thiamine_per_100g'] ?? 0,
                        'riboflavin_per_100g'    => $validated['riboflavin_per_100g'] ?? 0,
                        'niacin_per_100g'        => $validated['niacin_per_100g'] ?? 0,
                        'vitamin_c_per_100g'     => $validated['vitamin_c_per_100g'] ?? 0,
                        'bdd'                    => $validated['bdd'] ?? 100,
                    ]
                );
            } else {
                // Remove nutrition data if it's not a food category anymore
                $rawMaterial->nutrition()->delete();
            }
        });

        return redirect()->route('raw-materials.show', $rawMaterial)
            ->with('success', 'Bahan baku berhasil diperbarui!');
    }

    /**
     * Remove the specified raw material
     */
    public function destroy(RawMaterial $rawMaterial)
    {
        // Check if material is used in menus
        if ($rawMaterial->menuItems()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus bahan yang masih digunakan dalam menu!');
        }

        $rawMaterial->delete();

        return redirect()->route('raw-materials.index')
            ->with('success', 'Bahan baku berhasil dihapus!');
    }

    /**
     * Toggle raw material active status
     */
    public function toggleStatus(RawMaterial $rawMaterial)
    {
        $rawMaterial->update(['is_active' => !$rawMaterial->is_active]);
        
        $status = $rawMaterial->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return back()->with('success', "Bahan baku berhasil {$status}!");
    }
}
