<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                 <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xl">
                    {{ substr($rawMaterial->name, 0, 1) }}
                </div>
                <div>
                     <h2 class="text-2xl font-bold text-gray-900">{{ $rawMaterial->name }}</h2>
                    <div class="flex items-center gap-2 mt-1">
                        @if($rawMaterial->is_active)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-bold bg-green-100 text-green-700 uppercase tracking-wider">Aktif</span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-bold bg-red-100 text-red-700 uppercase tracking-wider">Nonaktif</span>
                        @endif
                         <span class="text-xs text-gray-400 font-medium">{{ $rawMaterial->code ? 'Kode: '.$rawMaterial->code : 'Tanpa Kode' }}</span>
                    </div>
                </div>
            </div>
            
            <div class="flex gap-3">
                <a href="{{ route('raw-materials.edit', $rawMaterial) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-bold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200 transition-all shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    Edit Data
                </a>
                <a href="{{ route('raw-materials.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-900 border border-transparent rounded-xl text-sm font-bold text-white hover:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-all shadow-lg">
                    Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Attributes & Nutrition -->
            <div class="space-y-6">
                <!-- Basic Attributes -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between items-center border-b border-gray-50 pb-3">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Kategori</span>
                            <span class="text-sm font-bold text-blue-600">{{ $rawMaterial->category?->name ?: '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-gray-50 pb-3">
                             <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Satuan Stok</span>
                            <span class="text-sm font-bold text-gray-900 lowercase">{{ $rawMaterial->unit }}</span>
                        </div>
                         <div class="flex justify-between items-center border-b border-gray-50 pb-3">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Harga / Unit</span>
                            <span class="text-sm font-bold text-gray-900">Rp {{ number_format($rawMaterial->price_per_unit) }}</span>
                        </div>
                        <div>
                             <span class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-1">Deskripsi</span>
                            <p class="text-sm text-gray-500 leading-relaxed">
                                {{ $rawMaterial->description ?: 'Tidak ada deskripsi.' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Nutrition Facts -->
                 @if($rawMaterial->nutrition)
                    <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl shadow-lg text-white p-6 relative overflow-hidden">
                         <div class="absolute top-0 right-0 -mt-6 -mr-6 w-32 h-32 bg-white opacity-5 rounded-full blur-2xl"></div>
                        <h3 class="text-sm font-black uppercase tracking-widest mb-6 flex items-center gap-2">
                             <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Nilai Gizi (per 100g)
                        </h3>
                        
                        <div class="space-y-4 relative z-10">
                             <div class="flex justify-between items-end">
                                <span class="text-xs text-gray-400 uppercase font-bold">Energi</span>
                                <span class="text-2xl font-black text-yellow-400">{{ number_format($rawMaterial->nutrition->energy_per_100g, 0) }} <span class="text-xs font-bold text-white/50">kcal</span></span>
                            </div>
                            <div class="w-full h-px bg-white/10"></div>
                            
                            <div class="grid grid-cols-3 gap-2 text-center">
                                <div>
                                    <div class="text-[10px] text-gray-400 uppercase font-bold mb-1">Prot</div>
                                    <div class="text-lg font-black text-white">{{ number_format($rawMaterial->nutrition->protein_per_100g, 1) }}g</div>
                                </div>
                                <div>
                                    <div class="text-[10px] text-gray-400 uppercase font-bold mb-1">Lemak</div>
                                    <div class="text-lg font-black text-white">{{ number_format($rawMaterial->nutrition->fat_per_100g, 1) }}g</div>
                                </div>
                                <div>
                                     <div class="text-[10px] text-gray-400 uppercase font-bold mb-1">Karbo</div>
                                    <div class="text-lg font-black text-white">{{ number_format($rawMaterial->nutrition->carbohydrate_per_100g, 1) }}g</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-gray-50 rounded-2xl border border-dashed border-gray-200 p-6 flex flex-col items-center justify-center text-center">
                        <svg class="w-8 h-8 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Tidak Ada Data Gizi</p>
                        <p class="text-xs text-gray-400 mt-1">Ubah kategori atau edit untuk menambahkan.</p>
                    </div>
                @endif
            </div>

            <!-- Middle Information: Stock Status & History -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Stock Summary Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                     <div class="bg-emerald-50 rounded-2xl p-5 border border-emerald-100 flex flex-col justify-between">
                         <div class="flex items-center gap-2 mb-2">
                             <div class="w-6 h-6 rounded-full bg-white text-emerald-600 flex items-center justify-center shadow-sm">
                                 <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span class="text-xs font-bold text-emerald-800 uppercase tracking-widest">Stok Tersedia</span>
                        </div>
                        <p class="text-2xl font-black text-emerald-900">{{ number_format($rawMaterial->getCurrentStock()) }} <span class="text-sm font-bold opacity-60">{{ $rawMaterial->unit }}</span></p>
                    </div>

                    <div class="bg-white rounded-2xl p-5 border border-gray-100">
                         <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Total Masuk</p>
                         <p class="text-xl font-bold text-gray-900">+{{ number_format($rawMaterial->stocks->where('type', 'in')->sum('quantity')) }}</p>
                    </div>

                    <div class="bg-white rounded-2xl p-5 border border-gray-100">
                         <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Total Keluar</p>
                         <p class="text-xl font-bold text-gray-900">-{{ number_format($rawMaterial->stocks->where('type', 'out')->sum('quantity')) }}</p>
                    </div>
                </div>

                <!-- History Table -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                     <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Pergerakan Stok Terakhir</h3>
                        <div class="flex gap-2">
                             <a href="{{ route('stocks.create', ['raw_material_id' => $rawMaterial->id, 'type' => 'in']) }}" class="inline-flex items-center px-3 py-1.5 bg-emerald-600 border border-transparent rounded-lg text-xs font-bold text-white uppercase tracking-wider hover:bg-emerald-700 transition-all shadow-sm">
                                + Masuk
                            </a>
                            <a href="{{ route('stocks.create', ['raw_material_id' => $rawMaterial->id, 'type' => 'out']) }}" class="inline-flex items-center px-3 py-1.5 bg-rose-600 border border-transparent rounded-lg text-xs font-bold text-white uppercase tracking-wider hover:bg-rose-700 transition-all shadow-sm">
                                - Keluar
                            </a>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        @if($rawMaterial->stocks->isEmpty())
                            <div class="p-12 text-center">
                                <p class="text-gray-400 text-sm font-medium">Belum ada riwayat stok untuk bahan ini.</p>
                            </div>
                        @else
                            <table class="min-w-full divide-y divide-gray-100">
                                <thead class="bg-gray-50/30">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Tipe</th>
                                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Jumlah</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Info</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($rawMaterial->stocks->sortByDesc('transaction_date')->take(5) as $stock)
                                        <tr class="hover:bg-gray-50/80 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex flex-col">
                                                    <span class="text-sm font-bold text-gray-900">{{ $stock->transaction_date->format('d M Y') }}</span>
                                                    <span class="text-xs text-gray-400">{{ $stock->created_at->format('H:i') }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                @if($stock->type === 'in')
                                                    <span class="px-2 py-1 text-[10px] font-bold rounded-md bg-emerald-100 text-emerald-700 uppercase tracking-wider border border-emerald-200">MASUK</span>
                                                @else
                                                     <span class="px-2 py-1 text-[10px] font-bold rounded-md bg-rose-100 text-rose-700 uppercase tracking-wider border border-rose-200">KELUAR</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <span class="font-black {{ $stock->type === 'in' ? 'text-emerald-600' : 'text-rose-600' }}">
                                                    {{ $stock->type === 'in' ? '+' : '-' }}{{ number_format($stock->quantity) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-xs text-gray-500 max-w-[150px] truncate">
                                                    {{ $stock->supplier ? 'Supp: '.$stock->supplier->name : ($stock->notes ?: '-') }}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                             <div class="px-6 py-3 bg-gray-50/30 border-t border-gray-100 text-center">
                                <a href="{{ route('stocks.index', ['raw_material_id' => $rawMaterial->id]) }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 uppercase tracking-wider">
                                    Lihat Semua Mutasi
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
