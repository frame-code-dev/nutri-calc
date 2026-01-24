<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Tambah Transaksi Stok</h2>
                <p class="text-sm text-gray-500 mt-1">Catat pergerakan stok masuk atau keluar.</p>
            </div>
            <a href="{{ route('stocks.index') }}" class="inline-flex items-center px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-700 font-semibold text-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200 transition-all shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
        </div>

        <div class="max-w-3xl mx-auto">
             <!-- Type Selection (Visual) -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <!-- Stock In Option -->
                <a href="?type=in" class="relative group block p-4 rounded-2xl border-2 transition-all {{ $type === 'in' ? 'bg-emerald-50 border-emerald-500 ring-4 ring-emerald-500/10' : 'bg-white border-gray-100 hover:border-emerald-200 hover:bg-emerald-50/50' }}">
                     <div class="flex items-center justify-between mb-2">
                        <div class="w-10 h-10 rounded-xl {{ $type === 'in' ? 'bg-emerald-500 text-white' : 'bg-emerald-100 text-emerald-600' }} flex items-center justify-center transition-colors">
                             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                        </div>
                        @if($type === 'in')
                            <div class="text-emerald-500">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            </div>
                        @endif
                    </div>
                    <p class="font-bold text-gray-900">Stok Masuk</p>
                    <p class="text-xs text-gray-500 mt-1">Penerimaan barang dari supplier</p>
                </a>
                
                <!-- Stock Out Option -->
                <a href="?type=out" class="relative group block p-4 rounded-2xl border-2 transition-all {{ $type === 'out' ? 'bg-rose-50 border-rose-500 ring-4 ring-rose-500/10' : 'bg-white border-gray-100 hover:border-rose-200 hover:bg-rose-50/50' }}">
                     <div class="flex items-center justify-between mb-2">
                        <div class="w-10 h-10 rounded-xl {{ $type === 'out' ? 'bg-rose-500 text-white' : 'bg-rose-100 text-rose-600' }} flex items-center justify-center transition-colors">
                             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                        </div>
                        @if($type === 'out')
                            <div class="text-rose-500">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            </div>
                        @endif
                    </div>
                    <p class="font-bold text-gray-900">Stok Keluar</p>
                    <p class="text-xs text-gray-500 mt-1">Penggunaan bahan untuk produksi</p>
                </a>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <form action="{{ route('stocks.store') }}" method="POST" class="p-8 space-y-6">
                    @csrf
                    <input type="hidden" name="type" value="{{ $type }}">
                    
                    <div class="space-y-6">
                         <!-- Raw Material -->
                        <div>
                            <label for="raw_material_id" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                Bahan Baku <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="raw_material_id" id="raw_material_id" required
                                    class="block w-full pl-4 pr-10 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-shadow appearance-none bg-white">
                                    <option value="">-- Pilih Bahan Baku --</option>
                                    @foreach($rawMaterials as $material)
                                        <option value="{{ $material->id }}" {{ old('raw_material_id') == $material->id ? 'selected' : '' }}>
                                            {{ $material->name }} ({{ $material->unit }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                            @error('raw_material_id')
                                <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                         @if($type === 'in')
                            <!-- Supplier -->
                             <div>
                                <label for="supplier_id" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                    Supplier (Opsional)
                                </label>
                                <div class="relative">
                                    <select name="supplier_id" id="supplier_id"
                                        class="block w-full pl-4 pr-10 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-shadow appearance-none bg-white">
                                        <option value="">-- Pilih Supplier --</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                                {{ $supplier->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                </div>
                                @error('supplier_id')
                                   <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                             <!-- Quantity -->
                            <div>
                                <label for="quantity" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                    Jumlah <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}" min="0.001" step="0.001" required
                                    class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-shadow"
                                    placeholder="0">
                                @error('quantity')
                                    <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                             <!-- Transaction Date -->
                             <div>
                                <label for="transaction_date" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                    Tanggal Transaksi <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="transaction_date" id="transaction_date" value="{{ old('transaction_date', date('Y-m-d')) }}" required
                                    class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-shadow">
                                @error('transaction_date')
                                    <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                         <!-- Notes -->
                         <div>
                            <label for="notes" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                Catatan (Opsional)
                            </label>
                            <textarea name="notes" id="notes" rows="3"
                                class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-shadow"
                                placeholder="Tambahkan keterangan tambahan...">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="pt-6 border-t border-gray-50 flex items-center justify-end gap-3">
                         <a href="{{ route('stocks.index') }}" class="px-6 py-3 bg-white border border-gray-200 rounded-xl text-sm font-bold text-gray-700 hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-200 transition-all shadow-sm">
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-{{ $type === 'in' ? 'emerald' : 'rose' }}-600 border border-transparent rounded-xl text-sm font-bold text-white hover:bg-{{ $type === 'in' ? 'emerald' : 'rose' }}-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-{{ $type === 'in' ? 'emerald' : 'rose' }}-500 transition-all shadow-lg shadow-{{ $type === 'in' ? 'emerald' : 'rose' }}-500/30">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
