<x-app-layout>
    <div class="py-10 bg-gray-50 flex-1">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl space-y-6">
            <!-- Header section -->
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Edit Menu</h2>
                    <p class="text-sm text-gray-500 mt-1">Perbarui informasi dan komposisi menu <span class="text-blue-600 font-bold">#{{ $menu->name }}</span></p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('menus.show', $menu) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-600 text-sm font-semibold rounded-xl hover:bg-gray-50 transition-all shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Batal
                    </a>
                </div>
            </div>

            <form id="menuForm" action="{{ route('menus.update', $menu) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <!-- Main Info Card -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/50">
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Informasi Dasar</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="name" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nama Menu <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name', $menu->name) }}" required
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/10 focus:border-blue-500 transition-all font-medium"
                                placeholder="Masukkan nama menu">
                            @error('name') <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="type" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Jenis Menu <span class="text-red-500">*</span></label>
                            <select name="type" id="type" required
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/10 focus:border-blue-500 transition-all font-bold text-gray-700">
                                <option value="wet" {{ old('type', $menu->type) === 'wet' ? 'selected' : '' }}>🍱 Menu Basah (Normal)</option>
                                <option value="dry" {{ old('type', $menu->type) === 'dry' ? 'selected' : '' }}>📦 Menu Kering (Libur)</option>
                            </select>
                            @error('type') <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-end pb-2">
                            <label class="inline-flex items-center cursor-pointer group">
                                <div class="relative">
                                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $menu->is_active) ? 'checked' : '' }} class="sr-only peer">
                                    <div class="w-10 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600"></div>
                                </div>
                                <span class="ml-3 text-sm font-semibold text-gray-600 group-hover:text-gray-900 transition-colors">Menu Aktif</span>
                            </label>
                        </div>

                        <div class="md:col-span-2">
                            <label for="description" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Deskripsi (Opsional)</label>
                            <textarea name="description" id="description" rows="3"
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/10 focus:border-blue-500 transition-all font-medium"
                                placeholder="Tuliskan deskripsi singkat mengenai menu ini...">{{ old('description', $menu->description) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Ingredients Card -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/50 flex items-center justify-between">
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Komposisi Bahan</h3>
                        <button type="button" id="addIngredient" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-blue-700 text-[11px] font-bold uppercase tracking-wider rounded-lg hover:bg-blue-600 hover:text-white transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Bahan
                        </button>
                    </div>
                    
                    <div id="ingredientsList" class="p-6 space-y-4">
                        <!-- Dynamic content -->
                    </div>

                    <div id="emptyState" class="p-12 text-center" style="display: none;">
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-gray-50 rounded-full mb-3">
                            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <p class="text-sm font-bold text-gray-400">Belum ada bahan ditambahkan</p>
                        <p class="text-xs text-gray-300 mt-1">Klik tombol "Tambah Bahan" untuk menyusun komposisi menu.</p>
                    </div>

                    <!-- Nutrition Footer Summary -->
                    <div id="nutritionPreview" class="border-t border-gray-50 bg-gray-50/30 p-6">
                        <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4">Estimasi Kandungan Gizi (per porsi)</h4>
                        <div class="grid grid-cols-2 sm:grid-cols-5 gap-4">
                            <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm">
                                <span class="block text-[9px] font-bold text-gray-400 uppercase tracking-tighter">Energi</span>
                                <span class="text-lg font-bold text-gray-900" id="preview-energy">0</span>
                                <span class="text-[10px] text-gray-400 font-medium ml-0.5">kkal</span>
                            </div>
                            <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm">
                                <span class="block text-[9px] font-bold text-gray-400 uppercase tracking-tighter">Protein</span>
                                <span class="text-lg font-bold text-gray-900" id="preview-protein">0</span>
                                <span class="text-[10px] text-gray-400 font-medium ml-0.5">g</span>
                            </div>
                            <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm">
                                <span class="block text-[9px] font-bold text-gray-400 uppercase tracking-tighter">Lemak</span>
                                <span class="text-lg font-bold text-gray-900" id="preview-fat">0</span>
                                <span class="text-[10px] text-gray-400 font-medium ml-0.5">g</span>
                            </div>
                            <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm">
                                <span class="block text-[9px] font-bold text-gray-400 uppercase tracking-tighter">Karbohidrat</span>
                                <span class="text-lg font-bold text-gray-900" id="preview-carb">0</span>
                                <span class="text-[10px] text-gray-400 font-medium ml-0.5">g</span>
                            </div>
                            <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm">
                                <span class="block text-[9px] font-bold text-gray-400 uppercase tracking-tighter">Serat</span>
                                <span class="text-lg font-bold text-gray-900" id="preview-fiber">0</span>
                                <span class="text-[10px] text-gray-400 font-medium ml-0.5">g</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Footer -->
                <div class="flex items-center justify-end gap-3 pt-2">
                    <a href="{{ route('menus.show', $menu) }}" class="px-6 py-2.5 text-sm font-semibold text-gray-500 hover:text-gray-900 transition-colors">Batal</a>
                    <button type="submit" class="px-8 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-500/20 transition-all transform active:scale-95">
                        Simpan Perubahan
                    </button>
                </div>
            </form>

            <div class="mt-12 pt-8 border-t border-gray-100">
                <div class="bg-rose-50/50 rounded-2xl border border-rose-100 p-6 flex flex-col md:flex-row items-center justify-between gap-4">
                    <div>
                        <h4 class="text-sm font-bold text-rose-900">Zona Bahaya</h4>
                        <p class="text-xs text-rose-600 mt-1">Menghapus menu ini akan menghilangkan semua data komposisi bahan secara permanen.</p>
                    </div>
                    <form action="{{ route('menus.destroy', $menu) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu ini? Tindakan ini tidak dapat dibatalkan.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-6 py-2 bg-white border border-rose-200 text-rose-600 text-xs font-bold uppercase tracking-wider rounded-xl hover:bg-rose-600 hover:text-white hover:border-rose-600 transition-all">
                            Hapus Menu
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        let ingredientIndex = 0;
        const materials = @json($rawMaterials);
        const existingItems = @json($menu->menuItems);
        const nutritionData = {};

        // Build nutrition lookup
        materials.forEach(material => {
            if (material.nutrition) {
                nutritionData[material.id] = {
                    energy: material.nutrition.energy_per_100g,
                    protein: material.nutrition.protein_per_100g,
                    fat: material.nutrition.fat_per_100g,
                    carbohydrate: material.nutrition.carbohydrate_per_100g,
                    fiber: material.nutrition.fiber_per_100g
                };
            }
        });

        document.getElementById('addIngredient').addEventListener('click', function() {
            addIngredientField();
        });

        function addIngredientField(materialId = '', quantity = '') {
            const container = document.getElementById('ingredientsList');
            const emptyState = document.getElementById('emptyState');
            
            const ingredientHtml = `
                <div class="ingredient-item bg-gray-50/50 p-4 rounded-2xl border border-gray-100 flex flex-col md:flex-row gap-4 items-end animate-in fade-in slide-in-from-bottom-2 duration-300" data-index="${ingredientIndex}">
                    <div class="flex-1 w-full">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Bahan Baku</label>
                        <select name="items[${ingredientIndex}][raw_material_id]" class="material-select block w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-all font-semibold" required onchange="calculateNutrition()">
                            <option value="">Pilih Bahan</option>
                            ${materials.map(m => `<option value="${m.id}" ${m.id == materialId ? 'selected' : ''}>${m.name} (${m.unit})</option>`).join('')}
                        </select>
                    </div>
                    <div class="w-full md:w-48">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Jumlah (per porsi)</label>
                        <div class="relative">
                            <input type="number" name="items[${ingredientIndex}][quantity_per_portion]" 
                                   class="quantity-input block w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-all font-bold pr-12" 
                                   min="0.001" step="0.001" required placeholder="0" value="${quantity}" oninput="calculateNutrition()">
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-bold text-gray-400">gr/ml</span>
                        </div>
                    </div>
                    <button type="button" onclick="removeIngredient(${ingredientIndex})" 
                            class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" title="Hapus Bahan">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', ingredientHtml);
            ingredientIndex++;
            emptyState.style.display = 'none';
            calculateNutrition();
        }

        function removeIngredient(index) {
            const item = document.querySelector(`.ingredient-item[data-index="${index}"]`);
            item.classList.add('animate-out', 'fade-out', 'slide-out-to-top-2', 'duration-200');
            setTimeout(() => {
                item.remove();
                const remaining = document.querySelectorAll('.ingredient-item');
                if (remaining.length === 0) {
                    document.getElementById('emptyState').style.display = 'block';
                    document.getElementById('nutritionPreview').style.display = 'none';
                }
                calculateNutrition();
            }, 200);
        }

        function calculateNutrition() {
            const items = document.querySelectorAll('.ingredient-item');
            let totals = { energy: 0, protein: 0, fat: 0, carbohydrate: 0, fiber: 0 };
            let hasSelection = false;
            
            items.forEach(item => {
                const materialId = item.querySelector('.material-select').value;
                const quantity = parseFloat(item.querySelector('.quantity-input').value) || 0;
                
                if (materialId && quantity && nutritionData[materialId]) {
                    hasSelection = true;
                    const factor = quantity / 100;
                    totals.energy += nutritionData[materialId].energy * factor;
                    totals.protein += nutritionData[materialId].protein * factor;
                    totals.fat += nutritionData[materialId].fat * factor;
                    totals.carbohydrate += nutritionData[materialId].carbohydrate * factor;
                    totals.fiber += nutritionData[materialId].fiber * factor;
                }
            });
            
            if (hasSelection) {
                document.getElementById('nutritionPreview').style.display = 'block';
                document.getElementById('preview-energy').textContent = Math.round(totals.energy);
                document.getElementById('preview-protein').textContent = totals.protein.toFixed(1);
                document.getElementById('preview-fat').textContent = totals.fat.toFixed(1);
                document.getElementById('preview-carb').textContent = totals.carbohydrate.toFixed(1);
                document.getElementById('preview-fiber').textContent = totals.fiber.toFixed(1);
            } else {
                document.getElementById('nutritionPreview').style.display = 'none';
            }
        }

        // Load existing items
        if (existingItems.length > 0) {
            existingItems.forEach(item => {
                addIngredientField(item.raw_material_id, item.quantity_per_portion);
            });
        } else {
            addIngredientField();
        }
    </script>
    @endpush
</x-app-layout>
