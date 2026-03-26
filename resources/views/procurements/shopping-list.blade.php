<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Daftar Belanja</h2>
                <p class="text-sm text-gray-500 mt-1">Kalkulasi kebutuhan bahan baku berdasarkan jadwal menu sekolah.</p>
            </div>

            <a href="{{ route('procurements.office') }}"
                class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-xl font-semibold text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all shadow-sm">
                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 012-2h2a2 2 0 012 2v16m-10 0V3a2 2 0 00-2-2H6a2 2 0 00-2 2v16m16 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Belanja Kantor
            </a>
        </div>

        <!-- Filter Date Range Card -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="text-sm font-bold text-gray-500 uppercase tracking-widest mb-4">Periode Belanja</h3>
            <form method="GET" action="{{ route('procurements.index') }}"
                class="flex flex-col md:flex-row md:items-end gap-6">
                <div class="flex-1 flex items-center gap-4">
                    <div class="flex-1">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Dari
                            Tanggal</label>
                        <input type="date" name="start_date" value="{{ $startDate }}"
                            class="block w-full px-3 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-shadow">
                    </div>
                    <span class="text-gray-400 font-bold mt-6">-</span>
                    <div class="flex-1">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Sampai
                            Tanggal</label>
                        <input type="date" name="end_date" value="{{ $endDate }}"
                            class="block w-full px-3 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-shadow">
                    </div>
                </div>
                <div>
                    <button type="submit"
                        class="w-full md:w-auto inline-flex items-center justify-center px-6 py-2.5 bg-blue-600 border border-transparent rounded-xl font-bold text-sm text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all shadow-lg shadow-blue-500/30">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        Hitung Kebutuhan
                    </button>
                </div>
            </form>
        </div>

        <!-- Warning for Unplanned Portions -->
        @if (isset($unplannedPortions) && $unplannedPortions > 0)
            <div class="rounded-2xl border-l-4 border-yellow-500 bg-yellow-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-bold text-yellow-800">Menu Belum Terencana</h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <p>
                                Terdeteksi <span
                                    class="font-bold border-b border-yellow-600">{{ number_format($unplannedPortions) }}
                                    porsi</span> yang diminta namun belum ada menu yang dijadwalkan.
                                Bahan baku untuk porsi ini tidak masuk dalam hitungan.
                            </p>
                            <p class="mt-2">
                                <a href="{{ route('menu-schedules.index') }}"
                                    class="text-yellow-800 underline hover:text-yellow-900 font-semibold">
                                    Atur Jadwal Menu &rarr;
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Results Table -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-gray-500 uppercase tracking-widest">Estimasi Kebutuhan</h3>
                    <p class="text-xs text-gray-400 font-medium mt-0.5">{{ count($ingredients) }} Item Total</p>
                </div>
                <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-blue-100 text-blue-700">
                    {{ \Carbon\Carbon::parse($startDate)->format('d M') }} -
                    {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Bahan Baku</th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Kebutuhan Total</th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Estimasi Biaya</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php $totalEstCost = 0; @endphp
                        @forelse($ingredients as $item)
                            <tr class="hover:bg-blue-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div
                                            class="h-8 w-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-500 mr-3">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-gray-900">
                                                {{ $item['raw_material']->name }}</div>
                                            <div class="text-xs font-medium text-gray-500 uppercase tracking-wide">
                                                {{ $item['raw_material']->category->name ?? 'General' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <span class="text-base font-bold text-gray-900">
                                        {{ number_format($item['total_quantity'], 2) }}
                                    </span>
                                    <span class="text-xs font-medium text-gray-500 ml-1">
                                        {{ $item['raw_material']->unit }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">Rp
                                        {{ number_format($item['total_cost_estimated'], 0, ',', '.') }}</div>
                                    <div class="text-[10px] text-gray-400">@ Rp
                                        {{ number_format($item['raw_material']->price_per_unit, 0, ',', '.') }} /
                                        {{ $item['raw_material']->unit }}</div>
                                </td>
                            </tr>
                            @php $totalEstCost += $item['total_cost_estimated']; @endphp
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada data belanja</h3>
                                    <p class="mt-1 text-sm text-gray-500">Silakan pilih periode tanggal dan pastikan
                                        menu sudah dijadwalkan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="2"
                                class="px-6 py-4 text-right text-sm font-bold text-gray-500 uppercase tracking-widest">
                                Total Estimasi Anggaran:</td>
                            <td class="px-6 py-4 text-right">
                                <span class="text-xl font-bold text-blue-600">
                                    Rp {{ number_format($totalEstCost, 0, ',', '.') }}
                                </span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
