<x-app-layout>
    <div class="py-10 bg-gray-50 flex-1">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl space-y-6">
            <!-- Header section -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Daftar Belanja</h2>
                    <p class="text-sm text-gray-500 mt-1">Kalkulasi kebutuhan bahan baku berdasarkan jadwal menu sekolah.</p>
                </div>
                <div>
                    <a href="{{ route('procurements.office') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-50 transition-all shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 012-2h2a2 2 0 012 2v16m-10 0V3a2 2 0 00-2-2H6a2 2 0 00-2 2v16m16 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        Belanja Kantor
                    </a>
                </div>
            </div>

            <!-- Filter Date Range Card -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 overflow-hidden">
                <form method="GET" action="{{ route('procurements.index') }}" class="flex flex-col md:flex-row md:items-end gap-6">
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Periode Belanja</label>
                        <div class="flex items-center gap-3">
                            <div class="relative flex-1">
                                <input type="date" name="start_date" value="{{ $startDate }}" 
                                    class="w-full pl-4 pr-10 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/10 focus:border-blue-500 transition-all font-semibold text-gray-700">
                            </div>
                            <span class="text-gray-300 font-bold">sampai</span>
                            <div class="relative flex-1">
                                <input type="date" name="end_date" value="{{ $endDate }}" 
                                    class="w-full pl-4 pr-10 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/10 focus:border-blue-500 transition-all font-semibold text-gray-700">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="px-8 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-500/20 transition-all transform active:scale-95 group flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-200 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        Hitung Kebutuhan
                    </button>
                </form>
            </div>

            <!-- Warning for Unplanned Portions -->
            @if(isset($unplannedPortions) && $unplannedPortions > 0)
                <div class="bg-amber-50 rounded-2xl border border-amber-100 p-5 flex gap-4 animate-in fade-in slide-in-from-top-2 duration-500">
                    <div class="flex-shrink-0 w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-amber-900 tracking-tight">Menu Belum Terencana</h4>
                        <p class="text-xs text-amber-700 mt-1 leading-relaxed">
                            Terdeteksi <span class="font-bold underline">{{ number_format($unplannedPortions) }} porsi</span> yang diminta namun <strong>belum ada menu yang dijadwalkan</strong>. Bahan baku untuk porsi ini tidak masuk dalam hitungan.
                        </p>
                        <a href="{{ route('menu-schedules.index') }}" class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-800 uppercase tracking-widest mt-3 hover:text-amber-900 transition-colors">
                            Atur Jadwal Menu
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </a>
                    </div>
                </div>
            @endif

            <!-- Results Table Card -->
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-8 py-5 border-b border-gray-50 flex items-center justify-between bg-gray-50/30">
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Estimasi Kebutuhan Bahan</h3>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">Total {{ count($ingredients) }} Item</p>
                    </div>
                    <div class="flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-blue-700 text-[10px] font-bold uppercase tracking-wider rounded-lg">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 00-2 2z"></path></svg>
                        {{ \Carbon\Carbon::parse($startDate)->format('d M') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th scope="col" class="px-8 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Detail Bahan Baku</th>
                                <th scope="col" class="px-8 py-4 text-right text-[10px] font-bold text-gray-400 uppercase tracking-widest">Kebutuhan Total</th>
                                <th scope="col" class="px-8 py-4 text-right text-[10px] font-bold text-gray-400 uppercase tracking-widest">Estimasi Biaya</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @php $totalEstCost = 0; @endphp
                            @forelse($ingredients as $item)
                                <tr class="group hover:bg-gray-50/50 transition-all duration-200 border-l-4 border-l-transparent hover:border-l-blue-600">
                                    <td class="px-8 py-5">
                                        <div class="text-sm font-black text-gray-900 tracking-tight">{{ $item['raw_material']->name }}</div>
                                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mt-0.5">{{ $item['raw_material']->category }}</div>
                                    </td>
                                    <td class="px-8 py-5 text-right">
                                        <span class="text-base font-black text-gray-900 tracking-tighter">
                                            {{ number_format($item['total_quantity'], 2) }}
                                        </span>
                                        <span class="text-[11px] font-bold text-gray-400 uppercase bg-gray-100 px-2 py-0.5 rounded-md ml-1 inline-block tracking-widest">
                                            {{ $item['raw_material']->unit }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-5 text-right">
                                        <div class="text-sm font-bold text-gray-700">Rp {{ number_format($item['total_cost_estimated'], 0, ',', '.') }}</div>
                                        <div class="text-[9px] text-gray-400 font-bold uppercase tracking-tighter">per unit: Rp {{ number_format($item['raw_material']->price_per_unit, 0, ',', '.') }}</div>
                                    </td>
                                </tr>
                                @php $totalEstCost += $item['total_cost_estimated']; @endphp
                            @empty
                                <tr>
                                    <td colspan="3" class="px-8 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-8 h-8 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                            </div>
                                            <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">Daftar Kosong</p>
                                            <p class="text-[10px] text-gray-300 font-bold uppercase tracking-widest mt-1">Ganti periode untuk menghitung kebutuhan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="bg-gray-50/50">
                            <tr>
                                <td colspan="2" class="px-8 py-6 text-right text-xs font-bold text-gray-500 uppercase tracking-widest">Total Estimasi Anggaran:</td>
                                <td class="px-8 py-6 text-right">
                                    <span class="text-2xl font-black text-blue-600 tracking-tighter italic">
                                        Rp {{ number_format($totalEstCost, 0, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
