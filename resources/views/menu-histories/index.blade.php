<x-app-layout>
    <div class="pb-12 bg-gray-50/50 min-h-screen">
        <div class="mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Header --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-black text-gray-900 tracking-tight">History Siklus Menu</h2>
                    <p class="text-sm font-medium text-gray-500 mt-1">Riwayat assignment menu mingguan</p>
                </div>
                <a href="{{ route('menu-schedules.index') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Siklus Menu
                </a>
            </div>

            {{-- Filter --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4">
                <form method="GET" action="{{ route('menu-histories.index') }}" class="flex flex-wrap items-center gap-3">
                    <select name="month" class="rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 py-2" onchange="this.form.submit()">
                        <option value="">Semua Bulan</option>
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ $filterMonth == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->isoFormat('MMMM') }}
                            </option>
                        @endfor
                    </select>
                    <select name="year" class="rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 py-2" onchange="this.form.submit()">
                        @for($y = 2024; $y <= 2026; $y++)
                            <option value="{{ $y }}" {{ $filterYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </form>
            </div>

            {{-- Table --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-100 bg-gray-50">
                            <th class="px-6 py-4">No. History</th>
                            <th class="px-6 py-4">Keterangan</th>
                            <th class="px-6 py-4">Minggu</th>
                            <th class="px-6 py-4">Progress</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($histories as $h)
                            @php
                                $pct   = $h->completion_percent;
                                $color = $pct >= 100 ? 'emerald' : ($pct > 0 ? 'indigo' : 'gray');
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="font-black text-indigo-700 text-sm tracking-widest font-mono">{{ $h->nomor }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-semibold text-gray-800">{{ $h->description }}</p>
                                    <p class="text-[10px] text-gray-400 mt-0.5">Dibuat oleh {{ $h->createdBy?->name ?? 'Sistem' }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-xs font-bold text-gray-600">Minggu {{ $h->week_number }}, {{ $h->year }}</span>
                                </td>
                                <td class="px-6 py-4 min-w-[140px]">
                                    <div class="flex items-center gap-2">
                                        <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                                            <div class="h-2 bg-{{ $color }}-500 rounded-full transition-all" style="width:{{ $pct }}%"></div>
                                        </div>
                                        <span class="text-[10px] font-black text-{{ $color }}-600">{{ $pct }}%</span>
                                    </div>
                                    <p class="text-[9px] text-gray-400 mt-1">
                                        {{ $h->days->where('status','selesai')->count() }}/{{ $h->days->count() }} hari selesai
                                    </p>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('menu-histories.show', $h) }}"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-50 text-indigo-700 text-xs font-bold rounded-lg hover:bg-indigo-100 transition-all">
                                        Detail
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center opacity-30">
                                        <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                        <p class="text-sm font-bold text-gray-400">Belum ada history</p>
                                        <p class="text-xs text-gray-300 mt-1">Simpan siklus menu untuk membuat history otomatis</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @if($histories->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $histories->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
