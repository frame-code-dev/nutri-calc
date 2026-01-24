<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Tambah Bahan Baku</h2>
                <p class="text-sm text-gray-500 mt-1">Tambahkan data bahan baku baru beserta informasi gizinya.</p>
            </div>
            <a href="{{ route('raw-materials.index') }}" class="inline-flex items-center px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-700 font-semibold text-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200 transition-all shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
        </div>

        <div class="max-w-4xl mx-auto" x-data="{ 
            categoryId: '{{ old('category_id') }}',
            foodCategoryId: '{{ $foodCategoryId }}' // Ensure this variable is passed from controller, usually it is.
        }">
            <form action="{{ route('raw-materials.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Main Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-8 space-y-8">
                        <!-- Basic Information Section -->
                        <div>
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
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
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                        class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-shadow @error('name') border-red-500 ring-red-500 @enderror"
                                        placeholder="Contoh: Daging Ayam Fillet">
                                    @error('name')
                                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Code -->
                                <div>
                                    <label for="code" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                        Kode / No SH (Opsional)
                                    </label>
                                    <input type="text" name="code" id="code" value="{{ old('code') }}"
                                        class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-shadow"
                                        placeholder="Contoh: RM-001">
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
                                            <option value="gram" {{ old('unit') === 'gram' ? 'selected' : '' }}>Gram (g)</option>
                                            <option value="kg" {{ old('unit') === 'kg' ? 'selected' : '' }}>Kilogram (kg)</option>
                                            <option value="ml" {{ old('unit') === 'ml' ? 'selected' : '' }}>Mililiter (ml)</option>
                                            <option value="liter" {{ old('unit') === 'liter' ? 'selected' : '' }}>Liter (L)</option>
                                            <option value="butir" {{ old('unit') === 'butir' ? 'selected' : '' }}>Butir</option>
                                            <option value="buah" {{ old('unit') === 'buah' ? 'selected' : '' }}>Buah</option>
                                            <option value="ikat" {{ old('unit') === 'ikat' ? 'selected' : '' }}>Ikat</option>
                                            <option value="pcs" {{ old('unit') === 'pcs' ? 'selected' : '' }}>Pcs</option>
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
                                        <input type="number" name="price_per_unit" id="price_per_unit" value="{{ old('price_per_unit') }}" min="0" step="0.01" required
                                            class="block w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-shadow"
                                            placeholder="0.00">
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
                                        class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-shadow"
                                        placeholder="Tambahkan catatan atau deskripsi singkat...">{{ old('description') }}</textarea>
                                </div>
                                
                                <!-- Active Status -->
                                <div class="md:col-span-2">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <div class="relative">
                                            <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', true) ? 'checked' : '' }}>
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
                             class="pt-6 border-t border-gray-100">
                             
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center text-green-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Data Nilai Gizi</h3>
                                    <p class="text-sm text-gray-500">Kandungan gizi per 100 gram/ml.</p>
                                </div>
                            </div>

                            <div class="bg-green-50/50 rounded-2xl border border-green-100 p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Energy -->
                                <div>
                                    <label for="energy_per_100g" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">
                                        Energi (kkal) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="energy_per_100g" id="energy_per_100g" value="{{ old('energy_per_100g') }}" min="0" step="0.1" :required="categoryId == foodCategoryId"
                                        class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm transition-shadow"
                                        placeholder="0">
                                    @error('energy_per_100g')
                                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Protein -->
                                <div>
                                    <label for="protein_per_100g" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">
                                        Protein (gram) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="protein_per_100g" id="protein_per_100g" value="{{ old('protein_per_100g') }}" min="0" step="0.1" :required="categoryId == foodCategoryId"
                                        class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm transition-shadow"
                                        placeholder="0">
                                    @error('protein_per_100g')
                                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Fat -->
                                <div>
                                    <label for="fat_per_100g" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">
                                        Lemak (gram) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="fat_per_100g" id="fat_per_100g" value="{{ old('fat_per_100g') }}" min="0" step="0.1" :required="categoryId == foodCategoryId"
                                        class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm transition-shadow"
                                        placeholder="0">
                                    @error('fat_per_100g')
                                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Carbohydrate -->
                                <div>
                                    <label for="carbohydrate_per_100g" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">
                                        Karbohidrat (gram) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="carbohydrate_per_100g" id="carbohydrate_per_100g" value="{{ old('carbohydrate_per_100g') }}" min="0" step="0.1" :required="categoryId == foodCategoryId"
                                        class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm transition-shadow"
                                        placeholder="0">
                                    @error('carbohydrate_per_100g')
                                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Fiber -->
                                <div>
                                    <label for="fiber_per_100g" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">
                                        Serat (gram) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="fiber_per_100g" id="fiber_per_100g" value="{{ old('fiber_per_100g') }}" min="0" step="0.1" :required="categoryId == foodCategoryId"
                                        class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm transition-shadow"
                                        placeholder="0">
                                    @error('fiber_per_100g')
                                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>
                    
                    <!-- Form Actions -->
                    <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-end gap-3">
                         <a href="{{ route('raw-materials.index') }}" class="px-6 py-3 bg-white border border-gray-200 rounded-xl text-sm font-bold text-gray-700 hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-200 transition-all shadow-sm">
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-xl text-sm font-bold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all shadow-lg shadow-blue-500/30">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Simpan Data
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
