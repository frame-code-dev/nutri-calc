<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-8">
        <!-- Header -->
        <div>
            <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Ringkasan Stok Bahan Baku</h2>
            <p class="text-sm text-gray-500 mt-2">Analisis menyeluruh ketersediaan bahan, nilai aset, dan peringatan stok.</p>
        </div>

        @php
            $lowStockCount = collect($stockSummary)->filter(function($item) {
                return $item['current_stock'] < 10000;
            })->count();
            $totalValue = collect($stockSummary)->sum('value');
        @endphp

        <!-- Metrics Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Total Items -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center gap-4 hover:shadow-md transition-shadow">
                <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600">
                     <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total SKU Bahan</p>
                    <p class="text-2xl font-black text-gray-900 mt-1">{{ count($stockSummary) }}</p>
                </div>
            </div>

            <!-- Low Stock Alert -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center gap-4 hover:shadow-md transition-shadow">
                <div class="w-14 h-14 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-600 relative">
                     <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                     @if($lowStockCount > 0)
                        <span class="absolute top-2 right-2 w-3 h-3 bg-rose-500 rounded-full border-2 border-white"></span>
                     @endif
                </div>
                <div>
                     <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Stok Menipis</p>
                    <p class="text-2xl font-black text-rose-600 mt-1">{{ $lowStockCount }}</p>
                </div>
            </div>

             <!-- Asset Value -->
            <div class="md:col-span-2 bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl shadow-lg p-6 flex items-center justify-between text-white relative overflow-hidden">
                 <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-white opacity-5 rounded-full blur-3xl"></div>
                 <div class="relative z-10">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Estimasi Nilai Aset</p>
                    <p class="text-3xl font-black tracking-tight">Rp {{ number_format($totalValue) }}</p>
                 </div>
                 <div class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center backdrop-blur-sm relative z-10">
                    <svg class="w-7 h-7 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                 </div>
            </div>
        </div>

        <!-- Detailed Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
             <div class="px-8 py-5 border-b border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Detail Stok Per Bahan</h3>
                <div class="flex gap-2">
                     <a href="{{ route('stocks.create', ['type' => 'in']) }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-xl text-xs font-bold text-white uppercase tracking-wider hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20">
                        <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Stok Masuk
                    </a>
                    <a href="{{ route('stocks.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-xl text-xs font-bold text-gray-600 uppercase tracking-wider hover:bg-gray-50 transition-all shadow-sm">
                        Mutasi Lengkap ->
                    </a>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Bahan Baku</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Ketersediaan</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Valuasi</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Mutasi Terakhir</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @foreach($stockSummary as $item)
                            @php
                                $isLowStock = $item['current_stock'] < 10000;
                            @endphp
                            <tr class="hover:bg-gray-50/80 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                         <div class="h-10 w-10 flex-shrink-0 bg-gray-100 rounded-lg flex items-center justify-center text-gray-500 font-bold text-xs uppercase mr-3">
                                            {{ substr($item['material']->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-gray-900">{{ $item['material']->name }}</div>
                                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mt-0.5">
                                                {{ $item['material']->category ?? 'General' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="inline-flex flex-col items-center">
                                        <span class="text-sm font-black {{ $isLowStock ? 'text-rose-600' : 'text-emerald-600' }}">
                                            {{ number_format($item['current_stock']) }}
                                            <span class="text-xs font-medium text-gray-400 ml-0.5">{{ $item['unit'] }}</span>
                                        </span>
                                        @if($isLowStock)
                                            <span class="mt-1 px-2 py-0.5 rounded-md bg-rose-50 text-rose-600 text-[10px] font-bold uppercase tracking-wider border border-rose-100">Stok Menipis</span>
                                        @else
                                             <span class="mt-1 px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-600 text-[10px] font-bold uppercase tracking-wider border border-emerald-100">Aman</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="text-sm font-bold text-gray-900">Rp {{ number_format($item['value']) }}</div>
                                    <div class="text-[10px] font-medium text-gray-400">@ Rp {{ number_format($item['material']->price_per_unit) }}</div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex flex-col items-end gap-1">
                                        @if($item['last_in'])
                                            <div class="flex items-center gap-1 text-[10px] text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                                                <span class="font-bold">{{ $item['last_in']->transaction_date->format('d/m') }}</span>
                                            </div>
                                        @endif
                                        @if($item['last_out'])
                                             <div class="flex items-center gap-1 text-[10px] text-rose-600 bg-rose-50 px-2 py-0.5 rounded-md border border-rose-100">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                                                <span class="font-bold">{{ $item['last_out']->transaction_date->format('d/m') }}</span>
                                            </div>
                                        @endif
                                        @if(!$item['last_in'] && !$item['last_out'])
                                            <span class="text-xs text-gray-300 font-bold">-</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('raw-materials.show', $item['material']) }}" class="text-blue-600 hover:text-blue-800 text-sm font-bold hover:underline">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if(count($stockSummary) === 0)
                <div class="p-12 text-center">
                    <p class="text-gray-400 text-sm font-medium">Belum ada data stok yang tersedia.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
