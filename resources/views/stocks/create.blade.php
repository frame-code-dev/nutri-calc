<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
                ➕ Tambah Transaksi Stok
            </h2>
            <a href="{{ route('stocks.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium inline-flex items-center">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <!-- Type Selection -->
            <div class="mb-8 p-4 bg-blue-50 rounded-lg border-2 border-blue-300">
                <p class="text-sm font-medium text-blue-900 mb-3">Pilih Jenis Transaksi:</p>
                <div class="grid grid-cols-2 gap-4">
                    <a href="?type=in" class="block p-4 text-center rounded-lg border-2 {{ $type === 'in' ? 'bg-green-100 border-green-500' : 'bg-white border-gray-300 hover:border-green-400' }}">
                        <div class="text-3xl mb-2">⬇️</div>
                        <div class="font-semibold {{ $type === 'in' ? 'text-green-700' : 'text-gray-700' }}">Stok Masuk</div>
                        <div class="text-xs text-gray-500">Dari supplier</div>
                    </a>
                    <a href="?type=out" class="block p-4 text-center rounded-lg border-2 {{ $type === 'out' ? 'bg-red-100 border-red-500' : 'bg-white border-gray-300 hover:border-red-400' }}">
                        <div class="text-3xl mb-2">⬆️</div>
                        <div class="font-semibold {{ $type === 'out' ? 'text-red-700' : 'text-gray-700' }}">Stok Keluar</div>
                        <div class="text-xs text-gray-500">Untuk produksi</div>
                    </a>
                </div>
            </div>

            <form action="{{ route('stocks.store') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="type" value="{{ $type }}">

                <!-- Raw Material -->
                <div>
                    <label for="raw_material_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Bahan Baku <span class="text-red-500">*</span>
                    </label>
                    <select name="raw_material_id" id="raw_material_id" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('raw_material_id') border-red-500 @enderror">
                        <option value="">-- Pilih Bahan Baku --</option>
                        @foreach($rawMaterials as $material)
                            <option value="{{ $material->id }}" {{ old('raw_material_id') == $material->id ? 'selected' : '' }}>
                                {{ $material->name }} ({{ $material->unit }})
                            </option>
                        @endforeach
                    </select>
                    @error('raw_material_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Supplier (only for IN) -->
                @if($type === 'in')
                    <div>
                        <label for="supplier_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Supplier
                        </label>
                        <select name="supplier_id" id="supplier_id"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('supplier_id') border-red-500 @enderror">
                            <option value="">-- Pilih Supplier (Opsional) --</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                @endif

                <!-- Quantity -->
                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
                        Jumlah <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}" min="0.001" step="0.001" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('quantity') border-red-500 @enderror"
                        placeholder="Masukkan jumlah">
                    @error('quantity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Satuan akan otomatis sesuai dengan bahan yang dipilih</p>
                </div>

                <!-- Transaction Date -->
                <div>
                    <label for="transaction_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Transaksi <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="transaction_date" id="transaction_date" value="{{ old('transaction_date', date('Y-m-d')) }}" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('transaction_date') border-red-500 @enderror">
                    @error('transaction_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                        Catatan (Opsional)
                    </label>
                    <textarea name="notes" id="notes" rows="3"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Tambahkan catatan tentang transaksi ini...">{{ old('notes') }}</textarea>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-4 border-t">
                    <a href="{{ route('stocks.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-3 rounded-lg font-medium">
                        Batal
                    </a>
                    <button type="submit" class="bg-{{ $type === 'in' ? 'green' : 'red' }}-600 hover:bg-{{ $type === 'in' ? 'green' : 'red' }}-700 text-white px-6 py-3 rounded-lg font-medium inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Transaksi
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
