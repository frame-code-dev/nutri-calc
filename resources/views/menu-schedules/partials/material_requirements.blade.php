<div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 sticky top-6">
    <div class="mb-6">
        <h3 class="text-lg font-bold text-gray-900">Kebutuhan Bahan</h3>
        <p class="text-xs text-gray-500">Estimasi untuk <span class="font-bold text-blue-600">{{ $selectedSchool?->name ?? 'Sekolah Terpilih' }}</span></p>
    </div>

    @if(empty($materialRequirements))
        <div class="flex flex-col items-center justify-center py-12 text-center opacity-30">
            <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            <p class="text-xs font-bold">Pilih menu untuk melihat stok</p>
        </div>
    @else
        <div class="space-y-4 max-h-[600px] overflow-y-auto custom-scrollbar pr-2">
             <!-- Cost Summary -->
            <div class="pb-4 border-b border-gray-100 mb-4">
                <div class="flex justify-between items-end mb-1">
                    <span class="text-xs font-bold text-gray-400 uppercase">Est. Biaya</span>
                    <span class="text-lg font-black text-gray-900">Rp {{ number_format($totalCost) }}</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                     <div class="bg-blue-500 h-1.5 rounded-full" style="width: {{ min(($totalCost / ($totalRab ?: 1)) * 100, 100) }}%"></div>
                </div>
            </div>

            @foreach($materialRequirements as $id => $mat)
                @php $isShortage = $mat['needed'] > $mat['stock']; @endphp
                <div class="group">
                    <div class="flex justify-between items-start mb-1">
                        <div class="flex-1">
                            <p class="text-xs font-bold text-gray-800 line-clamp-1">{{ $mat['name'] }}</p>
                            <p class="text-[9px] text-gray-400">Stok: {{ number_format($mat['stock']) }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-black text-gray-900">{{ number_format($mat['needed'], 1) }}</p>
                            <p class="text-[9px] text-gray-400">{{ $mat['unit'] }}</p>
                        </div>
                    </div>
                    @if($isShortage)
                        <div class="flex items-center gap-1 text-[9px] font-bold text-rose-500 bg-rose-50 px-1.5 py-0.5 rounded w-fit">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            Kurang {{ number_format($mat['needed'] - $mat['stock'], 1) }}
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
