<x-app-layout>
    <div class="py-10 bg-gray-50 flex-1">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 tracking-tight">{{ $kloter->name }}</h2>
                <p class="text-sm text-gray-500 mt-1">
                    @if($kloter->date) {{ $kloter->date->format('d F Y') }} • @endif
                    {{ $kloter->distributions->count() }} distribusi tergabung
                </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('kloters.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-600 text-sm font-semibold rounded-xl hover:bg-gray-50 transition-all shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali
                    </a>
                    <a href="{{ route('kloters.export-pdf', $kloter) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-xl hover:bg-red-700 transition-all shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Export PDF
                    </a>
                    <a href="{{ route('kloters.edit', $kloter) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition-all shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Edit
                    </a>
                </div>
            </div>

            @if($kloter->description)
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-6">
                    <p class="text-sm text-blue-900">{{ $kloter->description }}</p>
                </div>
            @endif

            <!-- Summary Stats -->
            @php
                $totalPk = $kloter->distributions->sum('small_portion_count');
                $totalPb = $kloter->distributions->sum('large_portion_count');
                $totalGuru = $kloter->distributions->sum('teacher_count');
                $totalJumlah = $totalPk + $totalPb + $totalGuru;
            @endphp

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-xl border border-gray-100 p-4">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">PK (Kecil)</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($totalPk) }}</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 p-4">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">PB (Besar)</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($totalPb) }}</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 p-4">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Guru</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($totalGuru) }}</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 p-4">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Total</p>
                    <p class="text-2xl font-bold text-blue-600">{{ number_format($totalJumlah) }}</p>
                </div>
            </div>

            <!-- Schools Table -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/50">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Daftar Sekolah</h3>
                </div>
                <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Sekolah / Unit</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">PK</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">PB</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Guru</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($kloter->distributions as $index => $dist)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                    {{ $dist->school->name }}
                                    @if($dist->name) <span class="text-xs text-gray-400">({{ $dist->name }})</span> @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-center text-gray-700">{{ number_format($dist->small_portion_count) }}</td>
                                <td class="px-6 py-4 text-sm text-center text-gray-700">{{ number_format($dist->large_portion_count) }}</td>
                                <td class="px-6 py-4 text-sm text-center text-gray-700">{{ number_format($dist->teacher_count) }}</td>
                                <td class="px-6 py-4 text-sm text-center font-bold text-gray-900">
                                    {{ number_format($dist->small_portion_count + $dist->large_portion_count + $dist->teacher_count) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500">
                                    Belum ada distribusi dalam kloter ini
                                </td>
                            </tr>
                        @endforelse
                        
                        @if($kloter->distributions->count() > 0)
                            <tr class="bg-blue-50 font-bold">
                                <td colspan="2" class="px-6 py-4 text-sm text-gray-900 uppercase">Total Keseluruhan</td>
                                <td class="px-6 py-4 text-sm text-center text-gray-900">{{ number_format($totalPk) }}</td>
                                <td class="px-6 py-4 text-sm text-center text-gray-900">{{ number_format($totalPb) }}</td>
                                <td class="px-6 py-4 text-sm text-center text-gray-900">{{ number_format($totalGuru) }}</td>
                                <td class="px-6 py-4 text-sm text-center text-blue-600">{{ number_format($totalJumlah) }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
