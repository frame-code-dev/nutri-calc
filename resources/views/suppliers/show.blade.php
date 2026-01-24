<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                 <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xl">
                    {{ substr($supplier->name, 0, 1) }}
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $supplier->name }}</h2>
                    <div class="flex items-center gap-2 mt-1">
                        @if($supplier->is_active)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-bold bg-green-100 text-green-700 uppercase tracking-wider">Aktif</span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-bold bg-red-100 text-red-700 uppercase tracking-wider">Nonaktif</span>
                        @endif
                        <span class="text-xs text-gray-400 font-medium">Terdaftar sejak {{ $supplier->created_at->format('M Y') }}</span>
                    </div>
                </div>
            </div>
            
            <div class="flex gap-3">
                <a href="{{ route('suppliers.edit', $supplier) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-bold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200 transition-all shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    Edit Profil
                </a>
                <a href="{{ route('suppliers.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-900 border border-transparent rounded-xl text-sm font-bold text-white hover:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-all shadow-lg">
                    Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Info & Stats -->
            <div class="lg:col-span-1 space-y-6">
                 <!-- Contact Info -->
                 <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Informasi Kontak</h3>
                        <div class="space-y-4">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400 flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <div class="text-sm">
                                    <p class="font-bold text-gray-900">Alamat</p>
                                    <p class="text-gray-500 leading-relaxed">{{ $supplier->address ?? '-' }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400 flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                </div>
                                <div class="text-sm">
                                    <p class="font-bold text-gray-900">Telepon</p>
                                    <p class="text-gray-500">{{ $supplier->phone ?? '-' }}</p>
                                </div>
                            </div>

                             <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400 flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </div>
                                <div class="text-sm">
                                    <p class="font-bold text-gray-900">Email</p>
                                    <p class="text-gray-500">{{ $supplier->email ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-blue-50 rounded-2xl p-5 border border-blue-100">
                        <p class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-1">Total Supply</p>
                        <p class="text-2xl font-black text-blue-900">{{ $supplier->stocks->where('type', 'in')->count() }}</p>
                        <p class="text-[10px] text-blue-500 font-medium">Kali Transaksi</p>
                    </div>
                     <div class="bg-emerald-50 rounded-2xl p-5 border border-emerald-100">
                        <p class="text-xs font-bold text-emerald-600 uppercase tracking-wider mb-1">Total Item</p>
                        <p class="text-2xl font-black text-emerald-900">{{ number_format($supplier->stocks->where('type', 'in')->sum('quantity')) }}</p>
                         <p class="text-[10px] text-emerald-500 font-medium">Unit Barang</p>
                    </div>
                </div>

                <!-- Action Card -->
                 <div class="bg-gray-900 rounded-2xl p-6 text-white shadow-lg">
                    <h3 class="font-bold text-lg mb-2">Input Stok Baru?</h3>
                    <p class="text-sm text-gray-400 mb-4">Catat penerimaan barang dari {{ $supplier->name }} dengan cepat.</p>
                    <a href="{{ route('stocks.create', ['supplier_id' => $supplier->id, 'type' => 'in']) }}" class="block w-full py-3 bg-white text-gray-900 font-bold text-center rounded-xl hover:bg-gray-100 transition-colors">
                        + Tambah Pasokan
                    </a>
                </div>
            </div>

            <!-- Right Column: History -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-900">Riwayat Pasokan Akhir-akhir Ini</h3>
                        @if($supplier->stocks->where('type', 'in')->count() > 0)
                         <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">
                            Terakhir: {{ $supplier->stocks->where('type', 'in')->last()->transaction_date->format('d M Y') }}
                        </span>
                        @endif
                    </div>
                    
                    <div class="overflow-x-auto">
                        @if($supplier->stocks->where('type', 'in')->isEmpty())
                            <div class="p-12 text-center">
                                <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mx-auto mb-4 text-gray-300">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                </div>
                                <h3 class="text-gray-900 font-bold mb-1">Belum Ada Riwayat</h3>
                                <p class="text-gray-500 text-sm">Supplier ini belum pernah melakukan pengiriman barang.</p>
                            </div>
                        @else
                            <table class="min-w-full divide-y divide-gray-100">
                                <thead class="bg-gray-50/50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Bahan Baku</th>
                                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Quantity</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Catatan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($supplier->stocks->where('type', 'in')->sortByDesc('transaction_date')->take(10) as $stock)
                                        <tr class="hover:bg-gray-50/80 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="flex flex-col">
                                                    <span class="text-sm font-bold text-gray-900">{{ $stock->transaction_date->format('d M Y') }}</span>
                                                    <span class="text-xs text-gray-400">{{ $stock->created_at->format('H:i') }} WIB</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-500">
                                                        {{ substr($stock->rawMaterial->name, 0, 2) }}
                                                    </div>
                                                    <span class="text-sm font-medium text-gray-900">{{ $stock->rawMaterial->name }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-sm font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">
                                                    +{{ number_format($stock->quantity) }} {{ $stock->rawMaterial->unit }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                 @if($stock->notes)
                                                    <p class="text-sm text-gray-600 italic truncate max-w-xs">"{{ $stock->notes }}"</p>
                                                @else
                                                    <span class="text-xs text-gray-300 font-medium">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                            @if($supplier->stocks->where('type', 'in')->count() > 10)
                                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30">
                                    <a href="{{ route('stocks.index', ['supplier_id' => $supplier->id]) }}" class="block w-full text-center text-sm font-bold text-blue-600 hover:text-blue-700 hover:underline">
                                        Lihat Seluruh Riwayat Transaksi
                                    </a>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
