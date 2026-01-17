<x-app-layout>
    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <a href="{{ route('stocks.index') }}" class="p-2 bg-white rounded-xl border border-gray-100 text-gray-400 hover:text-blue-600 hover:border-blue-100 transition-all shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </a>
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Detail Transaksi</span>
                    </div>
                    <h2 class="text-3xl font-black text-gray-900 tracking-tight">
                        {{ $stock->type === 'in' ? 'Stok Masuk' : 'Stok Keluar' }}
                    </h2>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('stocks.index') }}" class="px-6 py-3 bg-gray-900 text-white font-bold text-sm rounded-2xl border border-transparent hover:bg-black transition-all shadow-sm flex items-center gap-2">
                        Kembali ke Daftar
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Info -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Transaction Card -->
                    <div class="bg-white rounded-[40px] border border-gray-100 shadow-sm overflow-hidden">
                        <div class="p-8 md:p-12">
                            <div class="flex flex-col md:flex-row justify-between items-start gap-8">
                                <div class="space-y-6 flex-1">
                                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl {{ $stock->type === 'in' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                                        <div class="w-2 h-2 rounded-full animate-pulse {{ $stock->type === 'in' ? 'bg-emerald-500' : 'bg-rose-500' }}"></div>
                                        <span class="text-xs font-black uppercase tracking-widest">{{ $stock->type === 'in' ? 'Barang Masuk' : 'Barang Keluar' }}</span>
                                    </div>

                                    <div>
                                        <h3 class="text-4xl font-black text-gray-900">{{ number_format($stock->quantity) }}</h3>
                                        <p class="text-lg font-bold text-gray-400 mt-1">{{ $stock->rawMaterial->unit }} — {{ $stock->rawMaterial->name }}</p>
                                    </div>

                                    <div class="grid grid-cols-2 gap-8 pt-8 border-t border-gray-50">
                                        <div>
                                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Tanggal Transaksi</p>
                                            <p class="text-sm font-black text-gray-900">{{ $stock->transaction_date->isoFormat('DD MMMM YYYY') }}</p>
                                            <p class="text-xs font-medium text-gray-500">{{ $stock->transaction_date->format('H:i') }} WIB</p>
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Dicatat Oleh</p>
                                            <p class="text-sm font-black text-gray-900">{{ $stock->creator->name ?? 'System' }}</p>
                                            <p class="text-xs font-medium text-gray-500">Admin Gudang</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="w-full md:w-64 bg-gray-50 rounded-[32px] p-6 space-y-4">
                                    @if($stock->supplier)
                                        <div>
                                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Pemasok / Supplier</p>
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center font-black">
                                                    {{ substr($stock->supplier->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <p class="text-sm font-black text-gray-900">{{ $stock->supplier->name }}</p>
                                                    <p class="text-[10px] font-bold text-gray-400">{{ $stock->supplier->city ?? 'Lokalan' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <div>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Catatan Internal</p>
                                        <p class="text-sm font-medium text-gray-600 italic leading-relaxed">
                                            "{{ $stock->notes ?: 'Tidak ada catatan tambahan untuk transaksi ini.' }}"
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Material Details -->
                    <div class="bg-white rounded-[40px] border border-gray-100 shadow-sm p-8">
                        <div class="flex items-center justify-between mb-8">
                            <h4 class="text-lg font-black text-gray-900">Spesifikasi Bahan</h4>
                            <a href="{{ route('raw-materials.show', $stock->rawMaterial) }}" class="text-xs font-black text-blue-600 uppercase tracking-widest hover:text-blue-700 transition-colors">Lihat Katalog →</a>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                            <div class="p-4 bg-gray-50 rounded-3xl">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Satuan</p>
                                <p class="text-sm font-black text-gray-900">{{ $stock->rawMaterial->unit }}</p>
                            </div>
                            <div class="p-4 bg-gray-50 rounded-3xl">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Harga Satuan</p>
                                <p class="text-sm font-black text-gray-900">Rp {{ number_format($stock->rawMaterial->price_per_unit) }}</p>
                            </div>
                            <div class="p-4 bg-gray-50 rounded-3xl">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Nilai</p>
                                <p class="text-sm font-black text-blue-600">Rp {{ number_format($stock->quantity * $stock->rawMaterial->price_per_unit) }}</p>
                            </div>
                            <div class="p-4 bg-emerald-50 rounded-3xl">
                                <p class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest mb-1">Stok Gudang</p>
                                <p class="text-sm font-black text-emerald-600">{{ number_format($stock->rawMaterial->getCurrentStock()) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Nutrition Context -->
                <div class="space-y-8">
                    <div class="bg-gray-900 rounded-[40px] p-8 text-white shadow-xl shadow-gray-200">
                        <h4 class="text-lg font-black mb-6 flex items-center gap-2">
                             <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                             Nilai Gizi Per 100g
                        </h4>
                        
                        <div class="space-y-6">
                            @php $nutrition = $stock->rawMaterial->nutrition; @endphp
                            @if($nutrition)
                                <div>
                                    <div class="flex justify-between text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">
                                        <span>Energi</span>
                                        <span class="text-yellow-500">{{ $nutrition->energy_per_100g }} kcal</span>
                                    </div>
                                    <div class="w-full h-1 bg-white/10 rounded-full overflow-hidden">
                                        <div class="h-full bg-yellow-500" style="width: {{ min(100, ($nutrition->energy_per_100g/500)*100) }}%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">
                                        <span>Protein</span>
                                        <span class="text-blue-400">{{ $nutrition->protein_per_100g }}g</span>
                                    </div>
                                    <div class="w-full h-1 bg-white/10 rounded-full overflow-hidden">
                                        <div class="h-full bg-blue-400" style="width: {{ min(100, ($nutrition->protein_per_100g/30)*100) }}%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">
                                        <span>Lemak</span>
                                        <span class="text-rose-400">{{ $nutrition->fat_per_100g }}g</span>
                                    </div>
                                    <div class="w-full h-1 bg-white/10 rounded-full overflow-hidden">
                                        <div class="h-full bg-rose-400" style="width: {{ min(100, ($nutrition->fat_per_100g/30)*100) }}%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">
                                        <span>Karbohidrat</span>
                                        <span class="text-emerald-400">{{ $nutrition->carbohydrate_per_100g }}g</span>
                                    </div>
                                    <div class="w-full h-1 bg-white/10 rounded-full overflow-hidden">
                                        <div class="h-full bg-emerald-400" style="width: {{ min(100, ($nutrition->carbohydrate_per_100g/80)*100) }}%"></div>
                                    </div>
                                </div>
                            @else
                                <div class="py-8 text-center border-2 border-dashed border-white/10 rounded-3xl">
                                    <p class="text-xs font-bold text-gray-500">DATA GIZI TIDAK TERSEDIA</p>
                                </div>
                            @endif
                        </div>

                        <div class="mt-8 pt-8 border-t border-white/10">
                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest leading-relaxed">
                                Transaksi ini mempengaruhi ketersediaan nutrisi untuk program makan minggu ini.
                            </p>
                        </div>
                    </div>

                    <div class="bg-white rounded-[40px] border border-gray-100 shadow-sm p-8">
                        <h4 class="text-sm font-black text-gray-900 mb-4 uppercase tracking-widest">Keamanan Data</h4>
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <p class="text-[10px] font-bold text-gray-400 leading-relaxed uppercase tracking-widest">
                                SETIAP PERUBAHAN STOK DICATAT SECARA PERMANEN PADA SISTEM LOG AUDIT.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
