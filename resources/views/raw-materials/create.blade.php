<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
                ➕ Tambah Bahan Baku Baru
            </h2>
            <a href="{{ route('raw-materials.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium inline-flex items-center">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto" x-data="{ 
        categoryId: '{{ old('category_id') }}',
        foodCategoryId: '{{ $foodCategoryId }}'
    }">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <form action="{{ route('raw-materials.store') }}" method="POST" class="space-y-8">
                @csrf

                <!-- Basic Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b">📋 Informasi Dasar</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div class="md:col-span-1">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Bahan Baku <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                                placeholder="contoh: Ayam Goreng">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Code / No SH -->
                        <div class="md:col-span-1">
                            <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                                ID / No SH (Opsional)
                            </label>
                            <input type="text" name="code" id="code" value="{{ old('code') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('code') border-red-500 @enderror"
                                placeholder="contoh: ID21320000007770320">
                            @error('code')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div class="md:col-span-1">
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <select name="category_id" id="category_id" x-model="categoryId" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('category_id') border-red-500 @enderror">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Unit -->
                        <div>
                            <label for="unit" class="block text-sm font-medium text-gray-700 mb-2">
                                Satuan <span class="text-red-500">*</span>
                            </label>
                            <select name="unit" id="unit" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('unit') border-red-500 @enderror">
                                <option value="">-- Pilih Satuan --</option>
                                <option value="gram" {{ old('unit') === 'gram' ? 'selected' : '' }}>gram (g)</option>
                                <option value="ml" {{ old('unit') === 'ml' ? 'selected' : '' }}>mililiter (ml)</option>
                                <option value="butir" {{ old('unit') === 'butir' ? 'selected' : '' }}>butir</option>
                                <option value="buah" {{ old('unit') === 'buah' ? 'selected' : '' }}>buah</option>
                                <option value="kg" {{ old('unit') === 'kg' ? 'selected' : '' }}>kilogram (kg)</option>
                                <option value="liter" {{ old('unit') === 'liter' ? 'selected' : '' }}>liter (L)</option>
                            </select>
                            @error('unit')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div>
                            <label for="price_per_unit" class="block text-sm font-medium text-gray-700 mb-2">
                                Harga per Satuan (Rp) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="price_per_unit" id="price_per_unit" value="{{ old('price_per_unit') }}" min="0" step="0.01" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('price_per_unit') border-red-500 @enderror"
                                placeholder="contoh: 45">
                            @error('price_per_unit')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi (opsional)
                            </label>
                            <textarea name="description" id="description" rows="2"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Deskripsi singkat tentang bahan ini...">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Nutrition Data -->
                <div x-show="categoryId == foodCategoryId" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" class="bg-blue-50 p-6 rounded-xl border border-blue-100">
                    <h3 class="text-lg font-semibold text-blue-900 mb-4 pb-2 border-b border-blue-200">🥗 Data Gizi (per 100 gram/ml)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Energy -->
                        <div>
                            <label for="energy_per_100g" class="block text-sm font-medium text-gray-700 mb-2">
                                Energi (kkal) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="energy_per_100g" id="energy_per_100g" value="{{ old('energy_per_100g') }}" min="0" step="0.1" :required="categoryId == foodCategoryId"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('energy_per_100g') border-red-500 @enderror"
                                placeholder="contoh: 239">
                            @error('energy_per_100g')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Protein -->
                        <div>
                            <label for="protein_per_100g" class="block text-sm font-medium text-gray-700 mb-2">
                                Protein (gram) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="protein_per_100g" id="protein_per_100g" value="{{ old('protein_per_100g') }}" min="0" step="0.1" :required="categoryId == foodCategoryId"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('protein_per_100g') border-red-500 @enderror"
                                placeholder="contoh: 27.3">
                            @error('protein_per_100g')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Fat -->
                        <div>
                            <label for="fat_per_100g" class="block text-sm font-medium text-gray-700 mb-2">
                                Lemak (gram) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="fat_per_100g" id="fat_per_100g" value="{{ old('fat_per_100g') }}" min="0" step="0.1" :required="categoryId == foodCategoryId"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('fat_per_100g') border-red-500 @enderror"
                                placeholder="contoh: 13.6">
                            @error('fat_per_100g')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Carbohydrate -->
                        <div>
                            <label for="carbohydrate_per_100g" class="block text-sm font-medium text-gray-700 mb-2">
                                Karbohidrat (gram) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="carbohydrate_per_100g" id="carbohydrate_per_100g" value="{{ old('carbohydrate_per_100g') }}" min="0" step="0.1" :required="categoryId == foodCategoryId"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('carbohydrate_per_100g') border-red-500 @enderror"
                                placeholder="contoh: 0">
                            @error('carbohydrate_per_100g')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Fiber -->
                        <div>
                            <label for="fiber_per_100g" class="block text-sm font-medium text-gray-700 mb-2">
                                Serat (gram) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="fiber_per_100g" id="fiber_per_100g" value="{{ old('fiber_per_100g') }}" min="0" step="0.1" :required="categoryId == foodCategoryId"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('fiber_per_100g') border-red-500 @enderror"
                                placeholder="contoh: 0">
                            @error('fiber_per_100g')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Active Status -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Aktifkan bahan baku ini</span>
                    </label>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-4 border-t">
                    <a href="{{ route('raw-materials.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-3 rounded-lg font-medium">
                        Batal
                    </a>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Bahan Baku
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
