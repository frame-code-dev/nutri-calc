<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Edit Bahan Baku</h2>
                <p class="text-sm text-gray-500 mt-1">Perbarui data bahan baku dan informasi gizi.</p>
            </div>
            <a href="{{ route('raw-materials.index') }}" class="inline-flex items-center px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-700 font-semibold text-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200 transition-all shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
        </div>

        <div class="max-w-4xl mx-auto" x-data="{ 
            categoryId: '{{ old('category_id', $rawMaterial->category_id) }}',
            foodCategoryId: '{{ $foodCategoryId }}'
        }">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <form action="{{ route('raw-materials.update', $rawMaterial) }}" method="POST" class="p-8 space-y-8">
                    @csrf
                    @method('PUT')
                    
                    <!-- Basic Information Section -->
                    <div>
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Informasi Dasar</h3>
                                <p class="text-sm text-gray-500">Detail identitas dan klasifikasi bahan baku.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                    Nama Bahan <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name', $rawMaterial->name) }}" required
                                    class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-shadow @error('name') border-red-500 ring-red-500 @enderror">
                                @error('name')
                                    <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Code -->
                            <div>
                                <label for="code" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                    Kode / No SH (Opsional)
                                </label>
                                <input type="text" name="code" id="code" value="{{ old('code', $rawMaterial->code) }}"
                                    class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-shadow">
                                @error('code')
                                    <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div>
                                <label for="category_id" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                    Kategori <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select name="category_id" id="category_id" x-model="categoryId" required
                                        class="block w-full pl-4 pr-10 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-shadow appearance-none bg-white">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                </div>
                                @error('category_id')
                                    <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Unit -->
                            <div>
                                <label for="unit" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                    Satuan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select name="unit" id="unit" required
                                        class="block w-full pl-4 pr-10 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-shadow appearance-none bg-white">
                                        <option value="">-- Pilih Satuan --</option>
                                        <option value="gram" {{ old('unit', $rawMaterial->unit) === 'gram' ? 'selected' : '' }}>Gram (g)</option>
                                        <option value="kg" {{ old('unit', $rawMaterial->unit) === 'kg' ? 'selected' : '' }}>Kilogram (kg)</option>
                                        <option value="ml" {{ old('unit', $rawMaterial->unit) === 'ml' ? 'selected' : '' }}>Mililiter (ml)</option>
                                        <option value="liter" {{ old('unit', $rawMaterial->unit) === 'liter' ? 'selected' : '' }}>Liter (L)</option>
                                        <option value="butir" {{ old('unit', $rawMaterial->unit) === 'butir' ? 'selected' : '' }}>Butir</option>
                                        <option value="buah" {{ old('unit', $rawMaterial->unit) === 'buah' ? 'selected' : '' }}>Buah</option>
                                        <option value="ikat" {{ old('unit', $rawMaterial->unit) === 'ikat' ? 'selected' : '' }}>Ikat</option>
                                        <option value="pcs" {{ old('unit', $rawMaterial->unit) === 'pcs' ? 'selected' : '' }}>Pcs</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                </div>
                                @error('unit')
                                    <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Price -->
                             <div>
                                <label for="price_per_unit" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                    Harga per Satuan (Rp) <span class="text-red-500">*</span>
                                </label>
                                <div class="relative rounded-xl shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                        <span class="text-gray-500 sm:text-sm">Rp</span>
                                    </div>
                                    <input type="number" name="price_per_unit" id="price_per_unit" value="{{ old('price_per_unit', $rawMaterial->price_per_unit) }}" min="0" step="0.01" required
                                        class="block w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-shadow">
                                </div>
                                @error('price_per_unit')
                                    <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="md:col-span-2">
                                <label for="description" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                    Deskripsi
                                </label>
                                <textarea name="description" id="description" rows="3"
                                    class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-shadow">{{ old('description', $rawMaterial->description) }}</textarea>
                            </div>

                            <!-- Active Status -->
                            <div class="md:col-span-2">
                                <label class="inline-flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $rawMaterial->is_active) ? 'checked' : '' }}>
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    </div>
                                    <span class="ml-3 text-sm font-medium text-gray-900">Status Aktif</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Nutrition Data Section (Conditional) -->
                    <div x-show="categoryId == foodCategoryId" 
                         x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 transform -translate-y-4" 
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         class="pt-8 border-t border-gray-100">
                         
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center text-green-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Data Nilai Gizi</h3>
                                <p class="text-sm text-gray-500">Kandungan gizi per 100 gram BDD (sesuai kolom TKPI).</p>
                            </div>
                        </div>

                        <div class="bg-green-50/50 rounded-2xl border border-green-100 p-6 space-y-6">
                            <!-- Proksimat -->
                            <p class="text-xs font-bold text-green-700 uppercase tracking-widest">Proksimat</p>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @foreach([
                                    ['water_per_100g','Air – AIR (g)','0.1',false],
                                    ['energy_per_100g','Energi – ENERGI (kkal)','0.1',true],
                                    ['protein_per_100g','Protein – PROTEIN (g)','0.1',true],
                                    ['fat_per_100g','Lemak – LEMAK (g)','0.1',true],
                                    ['carbohydrate_per_100g','KH – KH (g)','0.1',true],
                                    ['fiber_per_100g','Serat – SERAT (g)','0.1',true],
                                    ['ash_per_100g','Abu – ABU (g)','0.1',false],
                                ] as [$field,$label,$step,$required])
                                <div>
                                    <label for="{{ $field }}" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">
                                        {{ $label }}@if($required) <span class="text-red-500">*</span>@endif
                                    </label>
                                    <input type="number" name="{{ $field }}" id="{{ $field }}"
                                        value="{{ old($field, $rawMaterial->nutrition?->$field ?? '') }}" min="0" step="{{ $step }}"
                                        @if($required) :required="categoryId == foodCategoryId" @endif
                                        class="block w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-shadow"
                                        placeholder="0">
                                    @error($field)<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                </div>
                                @endforeach
                            </div>

                            <!-- Mineral -->
                            <div class="pt-4 border-t border-green-200">
                                <p class="text-xs font-bold text-green-700 uppercase tracking-widest mb-4">Mineral (per 100g)</p>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    @foreach([
                                        ['calcium_per_100g','Kalsium – KALSI (mg)','0.01'],
                                        ['phosphorus_per_100g','Fosfor – FOSFO (mg)','0.01'],
                                        ['iron_per_100g','Besi – BESI (mg)','0.001'],
                                        ['sodium_per_100g','Natrium – NATRIU (mg)','0.01'],
                                        ['potassium_per_100g','Kalium – KALIU (mg)','0.01'],
                                        ['copper_per_100g','Tembaga – TEMBA (mg)','0.001'],
                                        ['zinc_per_100g','Seng – SENG (mg)','0.001'],
                                    ] as [$field,$label,$step])
                                    <div>
                                        <label for="{{ $field }}" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">{{ $label }}</label>
                                        <input type="number" name="{{ $field }}" id="{{ $field }}"
                                            value="{{ old($field, $rawMaterial->nutrition?->$field ?? '') }}" min="0" step="{{ $step }}"
                                            class="block w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-shadow"
                                            placeholder="0">
                                        @error($field)<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Vitamin -->
                            <div class="pt-4 border-t border-green-200">
                                <p class="text-xs font-bold text-green-700 uppercase tracking-widest mb-4">Vitamin (per 100g)</p>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    @foreach([
                                        ['retinol_per_100g','Retinol – RETINO (mcg)','0.01'],
                                        ['beta_carotene_per_100g','Beta-Karoten – B-KAR (mcg)','0.01'],
                                        ['carotene_per_100g','Karoten – KAR (mcg)','0.01'],
                                        ['thiamine_per_100g','Tiamin – THIAMI (mg)','0.001'],
                                        ['riboflavin_per_100g','Riboflavin – RIBOFL (mg)','0.001'],
                                        ['niacin_per_100g','Niasin – NIASIN (mg)','0.001'],
                                        ['vitamin_c_per_100g','Vit C – VIT_C (mg)','0.01'],
                                    ] as [$field,$label,$step])
                                    <div>
                                        <label for="{{ $field }}" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">{{ $label }}</label>
                                        <input type="number" name="{{ $field }}" id="{{ $field }}"
                                            value="{{ old($field, $rawMaterial->nutrition?->$field ?? '') }}" min="0" step="{{ $step }}"
                                            class="block w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-shadow"
                                            placeholder="0">
                                        @error($field)<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- BDD -->
                            <div class="pt-4 border-t border-green-200">
                                <p class="text-xs font-bold text-green-700 uppercase tracking-widest mb-4">Bagian yang Dapat Dimakan</p>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <div>
                                        <label for="bdd" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">BDD (%)</label>
                                        <input type="number" name="bdd" id="bdd"
                                            value="{{ old('bdd', $rawMaterial->nutrition?->bdd ?? 100) }}" min="0" max="100" step="0.01"
                                            class="block w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-shadow">
                                        @error('bdd')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                         <button type="button" @click="$refs.deleteForm.submit()" class="text-sm font-bold text-red-600 hover:text-red-800 focus:outline-none transition-colors">
                            Hapus Bahan
                        </button>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('raw-materials.index') }}" class="px-6 py-3 bg-white border border-gray-200 rounded-xl text-sm font-bold text-gray-700 hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-200 transition-all shadow-sm">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-xl text-sm font-bold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all shadow-lg shadow-blue-500/30">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
                
                <!-- Hidden Delete Form (Triggered via JS) -->
                <form x-ref="deleteForm" action="{{ route('raw-materials.destroy', $rawMaterial) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus bahan baku ini? Tindakan ini permanen.')" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
