<x-app-layout>
    <div class="py-10 bg-gray-50 flex-1">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl space-y-6">
            <!-- Header section -->
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Edit Menu</h2>
                    <p class="text-sm text-gray-500 mt-1">Perbarui informasi dan komposisi menu <span
                            class="text-blue-600 font-bold">#{{ $menu->name }}</span></p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('menus.show', $menu) }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-600 text-sm font-semibold rounded-xl hover:bg-gray-50 transition-all shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
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
                            <label for="name"
                                class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nama Menu
                                <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name', $menu->name) }}"
                                required
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/10 focus:border-blue-500 transition-all font-medium"
                                placeholder="Masukkan nama menu">
                            @error('name')
                                <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="type"
                                class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Jenis Menu
                                <span class="text-red-500">*</span></label>
                            <select name="type" id="type" required
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/10 focus:border-blue-500 transition-all font-bold text-gray-700">
                                <option value="wet" {{ old('type', $menu->type) === 'wet' ? 'selected' : '' }}>🍱
                                    Menu Basah (Normal)</option>
                                <option value="dry" {{ old('type', $menu->type) === 'dry' ? 'selected' : '' }}>📦
                                    Menu Kering (Libur)</option>
                            </select>
                            @error('type')
                                <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-end pb-2">
                            <label class="inline-flex items-center cursor-pointer group">
                                <div class="relative">
                                    <input type="checkbox" name="is_active" value="1"
                                        {{ old('is_active', $menu->is_active) ? 'checked' : '' }} class="sr-only peer">
                                    <div
                                        class="w-10 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                </div>
                                <span
                                    class="ml-3 text-sm font-semibold text-gray-600 group-hover:text-gray-900 transition-colors">Menu
                                    Aktif</span>
                            </label>
                        </div>

                        <div class="md:col-span-2">
                            <label for="description"
                                class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Deskripsi
                                (Opsional)</label>
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
                        <button type="button" id="addIngredient"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-blue-700 text-[11px] font-bold uppercase tracking-wider rounded-lg hover:bg-blue-600 hover:text-white transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Bahan
                        </button>
                    </div>

                    <div id="ingredientsList" class="p-6 space-y-4">
                        <!-- Dynamic content -->
                    </div>

                    <div id="emptyState" class="p-12 text-center" style="display: none;">
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-gray-50 rounded-full mb-3">
                            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <p class="text-sm font-bold text-gray-400">Belum ada bahan ditambahkan</p>
                        <p class="text-xs text-gray-300 mt-1">Klik tombol "Tambah Bahan" untuk menyusun komposisi menu.
                        </p>
                    </div>

                    <!-- Nutrition Footer Summary -->
                    <div id="nutritionPreview" class="border-t border-gray-50 bg-gray-50/30 p-6">
                        <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4">Estimasi
                            Kandungan Gizi (per porsi)</h4>
                        <div class="grid grid-cols-2 sm:grid-cols-5 gap-4">
                            <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm">
                                <span
                                    class="block text-[9px] font-bold text-gray-400 uppercase tracking-tighter">Energi</span>
                                <span class="text-lg font-bold text-gray-900" id="preview-energy">0</span>
                                <span class="text-[10px] text-gray-400 font-medium ml-0.5">kkal</span>
                            </div>
                            <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm">
                                <span
                                    class="block text-[9px] font-bold text-gray-400 uppercase tracking-tighter">Protein</span>
                                <span class="text-lg font-bold text-gray-900" id="preview-protein">0</span>
                                <span class="text-[10px] text-gray-400 font-medium ml-0.5">g</span>
                            </div>
                            <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm">
                                <span
                                    class="block text-[9px] font-bold text-gray-400 uppercase tracking-tighter">Lemak</span>
                                <span class="text-lg font-bold text-gray-900" id="preview-fat">0</span>
                                <span class="text-[10px] text-gray-400 font-medium ml-0.5">g</span>
                            </div>
                            <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm">
                                <span
                                    class="block text-[9px] font-bold text-gray-400 uppercase tracking-tighter">Karbohidrat</span>
                                <span class="text-lg font-bold text-gray-900" id="preview-carb">0</span>
                                <span class="text-[10px] text-gray-400 font-medium ml-0.5">g</span>
                            </div>
                            <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm">
                                <span
                                    class="block text-[9px] font-bold text-gray-400 uppercase tracking-tighter">Serat</span>
                                <span class="text-lg font-bold text-gray-900" id="preview-fiber">0</span>
                                <span class="text-[10px] text-gray-400 font-medium ml-0.5">g</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Footer -->
                <div class="flex items-center justify-end gap-3 pt-2">
                    <a href="{{ route('menus.show', $menu) }}"
                        class="px-6 py-2.5 text-sm font-semibold text-gray-500 hover:text-gray-900 transition-colors">Batal</a>
                    <button type="submit"
                        class="px-8 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-500/20 transition-all transform active:scale-95">
                        Simpan Perubahan
                    </button>
                </div>
            </form>

            <div class="mt-12 pt-8 border-t border-gray-100">
                <div
                    class="bg-rose-50/50 rounded-2xl border border-rose-100 p-6 flex flex-col md:flex-row items-center justify-between gap-4">
                    <div>
                        <h4 class="text-sm font-bold text-rose-900">Zona Bahaya</h4>
                        <p class="text-xs text-rose-600 mt-1">Menghapus menu ini akan menghilangkan semua data
                            komposisi bahan secara permanen.</p>
                    </div>
                    <form action="{{ route('menus.destroy', $menu) }}" method="POST"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu ini? Tindakan ini tidak dapat dibatalkan.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-6 py-2 bg-white border border-rose-200 text-rose-600 text-xs font-bold uppercase tracking-wider rounded-xl hover:bg-rose-600 hover:text-white hover:border-rose-600 transition-all">
                            Hapus Menu
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <style>
        .ts-control {
            border-radius: 0.75rem;
            padding: 0.625rem 0.75rem;
            border-color: #e5e7eb;
            font-size: 0.875rem;
            background-color: #f9fafb;
        }

        .ts-wrapper.focus .ts-control {
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1);
        }

        .ts-dropdown {
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            border-color: #e5e7eb;
            z-index: 50;
        }

        .ts-dropdown .optgroup-header {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #9ca3af;
            background-color: #f9fafb;
        }
    </style>

    @push('scripts')
        <script>
            let ingredientIndex = 0;
            const materials = @json($rawMaterials);
            const categories = @json($categories);
            const existingItems = @json($menu->menuItems);
            const nutritionData = {};
            const tomSelectInstances = {};

            // Common units for selection
            const commonUnits = ['kg', 'gr', 'ltr', 'ml', 'pcs', 'butir', 'ikat', 'siung', 'batang', 'lembar', 'sdm', 'sdt',
                'porsi', 'bungkus', 'kaleng', 'botol', 'gelas', 'mangkok', 'piring'
            ];

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

            // Load existing items with Grouping Logic
            if (existingItems.length > 0) {
                // Group items by group_name
                const groupedItems = {};
                const noGroupItems = [];

                existingItems.forEach(item => {
                    if (item.group_name) {
                        if (!groupedItems[item.group_name]) {
                            groupedItems[item.group_name] = [];
                        }
                        groupedItems[item.group_name].push(item);
                    } else {
                        noGroupItems.push(item);
                    }
                });

                // Render Groups
                for (const [groupName, items] of Object.entries(groupedItems)) {
                    createGroup(groupName, items);
                }

                // Render Non-Grouped Items (Legacy or manual)
                if (noGroupItems.length > 0) {
                    // Treat them as a "General" group or just loose items? 
                    // Let's create a "Manual" group to be consistent, or just append them.
                    // Ideally, we append them to a default container.
                    // For simplycity/consistency, let's create a "Tambahan" group if groups exist, or just loose if no groups.
                    const container = document.getElementById('ingredientsList');

                    // If we have groups, let's label this "Bahan Tambahan"
                    if (Object.keys(groupedItems).length > 0) {
                        createGroup("Bahan Tambahan / Manual", noGroupItems, false);
                    } else {
                        noGroupItems.forEach(item => {
                            addIngredientField(item);
                        });
                    }
                }
            } else {
                addIngredientField(); // Empty state start
            }

            function createGroup(groupName, items, isDeletable = true) {
                const mainContainer = document.getElementById('ingredientsList');
                const groupId = 'group-' + Math.random().toString(36).substr(2, 9);

                const groupHtml = `
                    <div id="${groupId}" class="bg-white border border-gray-200 rounded-2xl overflow-hidden mb-6 shadow-sm group-container">
                        <div class="px-6 py-3 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                            <h4 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                                <span class="w-2 h-6 bg-blue-500 rounded-full"></span>
                                ${groupName}
                            </h4>
                            ${isDeletable ? `
                                    <button type="button" onclick="removeGroup('${groupId}')" 
                                        class="text-xs font-bold text-red-500 hover:text-red-700 hover:bg-red-50 px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        Hapus Menu Ini
                                    </button>` : ''}
                        </div>
                        <div class="p-4 space-y-4 item-container">
                            <!-- Items go here -->
                        </div>
                    </div>
                `;

                mainContainer.insertAdjacentHTML('beforeend', groupHtml);
                const groupContainer = document.getElementById(groupId).querySelector('.item-container');

                items.forEach(item => {
                    addIngredientField(item, groupContainer, groupName);
                });
            }

            function removeGroup(groupId) {
                if (!confirm('Apakah Anda yakin ingin menghapus seluruh bahan dari menu ini?')) return;

                const groupEl = document.getElementById(groupId);
                const itemEls = groupEl.querySelectorAll('.ingredient-item');

                // Cleanup Select Instances
                itemEls.forEach(item => {
                    const index = item.getAttribute('data-index');
                    if (tomSelectInstances[index]) {
                        tomSelectInstances[index].destroy();
                        delete tomSelectInstances[index];
                    }
                });

                groupEl.remove();

                // Check if totally empty
                const remaining = document.querySelectorAll('.ingredient-item');
                if (remaining.length === 0) {
                    document.getElementById('emptyState').style.display = 'block';
                    document.getElementById('nutritionPreview').style.display = 'none';
                }

                calculateNutrition();
            }

            document.getElementById('addIngredient').addEventListener('click', function() {
                // When adding manually, we just add to the main list (no group or default group)
                // If there's a "Bahan Tambahan" group, maybe add there? 
                // For now, simpler is straight to list, effectively "Manual" mode.
                addIngredientField();
            });

            function addIngredientField(itemData = null, container = null, groupName = null) {
                const targetContainer = container || document.getElementById('ingredientsList');
                const emptyState = document.getElementById('emptyState');

                // Build Options with Optgroups (Existing logic)
                let optionsHtml = '<option value="">Pilih Bahan</option>';

                categories.forEach(cat => {
                    const catMaterials = materials.filter(m => m.category_id == cat.id);
                    if (catMaterials.length > 0) {
                        optionsHtml += `<optgroup label="${cat.name}">`;
                        catMaterials.forEach(m => {
                            let selected = '';
                            if (itemData && itemData.raw_material_id == m.id) {
                                selected = 'selected';
                            }
                            optionsHtml +=
                                `<option value="${m.id}" data-unit="${m.unit}" ${selected}>${m.name} (Base: ${m.unit})</option>`;
                        });
                        optionsHtml += `</optgroup>`;
                    }
                });

                const uncategorized = materials.filter(m => !m.category_id);
                if (uncategorized.length > 0) {
                    optionsHtml += `<optgroup label="Lainnya">`;
                    uncategorized.forEach(m => {
                        let selected = '';
                        if (itemData && itemData.raw_material_id == m.id) {
                            selected = 'selected';
                        }
                        optionsHtml +=
                            `<option value="${m.id}" data-unit="${m.unit}" ${selected}>${m.name} (Base: ${m.unit})</option>`;
                    });
                    optionsHtml += `</optgroup>`;
                }

                // Prepare Values
                let qtyInputVal = '';
                let qtyPerPortionVal = '';
                let unitVal = '';
                let convFactorVal = 1;
                let groupNameVal = groupName || (itemData ? itemData.group_name : null) || '';

                if (itemData) {
                    const mat = materials.find(m => m.id == itemData.raw_material_id);
                    unitVal = itemData.unit || (mat ? mat.unit : '');
                    qtyInputVal = itemData.quantity_input !== null ? itemData.quantity_input : itemData.quantity_per_portion;
                    qtyPerPortionVal = itemData.quantity_per_portion;
                    convFactorVal = itemData.conversion_factor !== null ? itemData.conversion_factor : 1;
                }

                // Build Unit Options
                let unitOptionsHtml = '<option value="">Satuan</option>';
                commonUnits.forEach(u => {
                    let selected = (u === unitVal) ? 'selected' : '';
                    unitOptionsHtml += `<option value="${u}" ${selected}>${u}</option>`;
                });

                const ingredientHtml = `
                <div class="ingredient-item bg-white p-0 rounded-xl flex flex-col gap-4 animate-in fade-in slide-in-from-bottom-2 duration-300 md:border-b md:border-gray-50 pb-4 mb-2 last:border-0 last:mb-0 last:pb-0" data-index="${ingredientIndex}">
                    <input type="hidden" name="items[${ingredientIndex}][group_name]" value="${groupNameVal}">
                    
                    <div class="flex flex-col md:flex-row gap-4 items-start">
                        <div class="flex-1 w-full relative">
                             ${!container ? '<label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Bahan Baku</label>' : ''}
                            <select name="items[${ingredientIndex}][raw_material_id]" id="select-${ingredientIndex}" class="material-select block w-full" required>
                                ${optionsHtml}
                            </select>
                        </div>
                        
                        <div class="w-full md:w-32">
                             ${!container ? '<label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Satuan</label>' : ''}
                             <select name="items[${ingredientIndex}][unit]" id="unit-${ingredientIndex}" class="unit-select block w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500 font-bold" required onchange="handleUnitChange(${ingredientIndex})">
                                ${unitOptionsHtml}
                             </select>
                        </div>

                        <div class="w-full md:w-40">
                            ${!container ? '<label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Jumlah</label>' : ''}
                            <input type="number" name="items[${ingredientIndex}][quantity_input]" id="qty-${ingredientIndex}"
                                   class="quantity-input block w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-all font-bold" 
                                   min="0.001" step="0.001" required placeholder="0" value="${qtyInputVal}" oninput="calculateRow(${ingredientIndex})">
                        </div>
                        
                        <div class="${!container ? 'mt-7' : ''} flex items-center">
                            <button type="button" onclick="removeIngredient(${ingredientIndex})" 
                                    class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" title="Hapus Bahan">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>

                    <div id="conversion-row-${ingredientIndex}" class="hidden w-full bg-yellow-50 rounded-xl p-3 border border-yellow-100">
                        <div class="flex items-center gap-3 text-sm text-yellow-800">
                            <div class="flex items-center gap-2 flex-1 flex-wrap">
                                <span class="font-bold whitespace-nowrap">Konversi:</span>
                                <span>1 <span id="label-unit-selected-${ingredientIndex}" class="font-bold underline">Unit</span> = </span>
                                <input type="number" name="items[${ingredientIndex}][conversion_factor]" id="conv-${ingredientIndex}"
                                   class="conversion-input w-24 px-2 py-1 bg-white border border-yellow-300 rounded text-sm focus:ring-1 focus:ring-yellow-500 focus:border-yellow-500 font-bold text-center"
                                   min="0.0001" step="0.0001" value="${convFactorVal}" oninput="calculateRow(${ingredientIndex})">
                                <span id="label-unit-base-${ingredientIndex}" class="font-bold">Base</span>
                            </div>
                        </div>
                    </div>
                    
                    <input type="hidden" name="items[${ingredientIndex}][quantity_per_portion]" id="calc-${ingredientIndex}" value="${qtyPerPortionVal}">
                </div>
            `;

                targetContainer.insertAdjacentHTML('beforeend', ingredientHtml);
                // ... (rest of logic: TomSelect, conversion visibility remains same)

                const selectEl = document.getElementById(`select-${ingredientIndex}`);
                const ts = new TomSelect(selectEl, {
                    create: false,
                    sortField: {
                        field: "text",
                        direction: "asc"
                    },
                    placeholder: "Cari bahan baku...",
                    onChange: function(value) {
                        handleMaterialChange(ingredientIndex, value);
                    }
                });
                tomSelectInstances[ingredientIndex] = ts;

                if (itemData && itemData.raw_material_id) {
                    const mat = materials.find(m => m.id == itemData.raw_material_id);
                    const unitSelect = document.getElementById(`unit-${ingredientIndex}`);
                    if (unitVal && mat && unitVal !== mat.unit) {
                        let found = false;
                        for (let i = 0; i < unitSelect.options.length; i++) {
                            if (unitSelect.options[i].value === unitVal) {
                                found = true;
                                break;
                            }
                        }
                        if (!found) {
                            unitSelect.add(new Option(unitVal, unitVal));
                            unitSelect.value = unitVal;
                        }
                    }

                    document.getElementById(`label-unit-selected-${ingredientIndex}`).textContent = unitVal;
                    if (mat) {
                        document.getElementById(`label-unit-base-${ingredientIndex}`).textContent = mat.unit;
                        if (unitVal && mat.unit && unitVal.toLowerCase() !== mat.unit.toLowerCase()) {
                            document.getElementById(`conversion-row-${ingredientIndex}`).classList.remove('hidden');
                        }
                    }
                }

                ingredientIndex++;
                emptyState.style.display = 'none';
            }
        </script>
    @endpush
</x-app-layout>
