<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Laporan Gizi Mingguan</h2>
                <p class="mt-1 text-sm text-gray-600">{{ $school->name }} - Minggu {{ $weekNumber }}, {{ $year }}</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('nutrition-reports.school-weekly', ['school_id' => $school->id, 'week_number' => $weekNumber, 'year' => $year, 'format' => 'pdf']) }}" 
                   class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium inline-flex items-center transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Download PDF
                </a>
                <a href="{{ route('nutrition-reports.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg font-medium transition-colors">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- School Info -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ $school->name }}</h3>
                    <p class="text-sm text-gray-600 mt-1">{{ $school->address }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Total Siswa</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($school->student_count) }}</p>
                </div>
            </div>
        </div>

        <!-- Weekly Nutrition Summary -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Rata-Rata Gizi Per Hari</h3>
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <!-- Energy -->
                <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 border-2 border-yellow-200 rounded-xl p-4 text-center">
                    <div class="text-sm font-medium text-yellow-600 mb-1">Energi</div>
                    <div class="text-2xl font-bold text-yellow-900">{{ number_format($nutrition['daily_average']['energy'], 0) }}</div>
                    <div class="text-xs text-yellow-700 mt-1">kcal</div>
                </div>

                <!-- Protein -->
                <div class="bg-gradient-to-br from-red-50 to-red-100 border-2 border-red-200 rounded-xl p-4 text-center">
                    <div class="text-sm font-medium text-red-600 mb-1">Protein</div>
                    <div class="text-2xl font-bold text-red-900">{{ number_format($nutrition['daily_average']['protein'], 1) }}</div>
                    <div class="text-xs text-red-700 mt-1">gram</div>
                </div>

                <!-- Fat -->
                <div class="bg-gradient-to-br from-orange-50 to-orange-100 border-2 border-orange-200 rounded-xl p-4 text-center">
                    <div class="text-sm font-medium text-orange-600 mb-1">Lemak</div>
                    <div class="text-2xl font-bold text-orange-900">{{ number_format($nutrition['daily_average']['fat'], 1) }}</div>
                    <div class="text-xs text-orange-700 mt-1">gram</div>
                </div>

                <!-- Carbohydrate -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200 rounded-xl p-4 text-center">
                    <div class="text-sm font-medium text-blue-600 mb-1">Karbohidrat</div>
                    <div class="text-2xl font-bold text-blue-900">{{ number_format($nutrition['daily_average']['carbohydrate'], 1) }}</div>
                    <div class="text-xs text-blue-700 mt-1">gram</div>
                </div>

                <!-- Fiber -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 border-2 border-green-200 rounded-xl p-4 text-center">
                    <div class="text-sm font-medium text-green-600 mb-1">Serat</div>
                    <div class="text-2xl font-bold text-green-900">{{ number_format($nutrition['daily_average']['fiber'], 1) }}</div>
                    <div class="text-xs text-green-700 mt-1">gram</div>
                </div>
            </div>
        </div>

        <!-- Daily Breakdown -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Rincian Per Hari</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Menu</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Energi</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Protein</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Lemak</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Karbo</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Serat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($calendars as $calendar)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($calendar->date)->format('D, d M Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($calendar->menu)
                                        <div class="text-sm font-medium text-gray-900">{{ $calendar->menu->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $calendar->menu->type === 'wet' ? 'Basah' : 'Kering' }}</div>
                                    @else
                                        <span class="text-sm text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($calendar->day_status === 'receive')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Menerima</span>
                                    @elseif($calendar->day_status === 'holiday')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Libur</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Belum</span>
                                    @endif
                                </td>
                                @if($calendar->menu && $calendar->day_status === 'receive')
                                    @php
                                        $menuNutrition = $calendar->menu->calculateNutrition();
                                    @endphp
                                    <td class="px-6 py-4 text-sm text-right font-medium text-yellow-700">{{ number_format($menuNutrition['energy'], 0) }}</td>
                                    <td class="px-6 py-4 text-sm text-right font-medium text-red-700">{{ number_format($menuNutrition['protein'], 1) }}</td>
                                    <td class="px-6 py-4 text-sm text-right font-medium text-orange-700">{{ number_format($menuNutrition['fat'], 1) }}</td>
                                    <td class="px-6 py-4 text-sm text-right font-medium text-blue-700">{{ number_format($menuNutrition['carbohydrate'], 1) }}</td>
                                    <td class="px-6 py-4 text-sm text-right font-medium text-green-700">{{ number_format($menuNutrition['fiber'], 1) }}</td>
                                @else
                                    <td colspan="5" class="px-6 py-4 text-sm text-center text-gray-400">-</td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                    Tidak ada data untuk minggu ini
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Weekly Total -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg p-6 text-white">
            <h3 class="text-lg font-semibold mb-4">Total Gizi Minggu Ini</h3>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                <div>
                    <p class="text-blue-200 text-sm">Energi</p>
                    <p class="text-2xl font-bold">{{ number_format($nutrition['weekly_total']['energy'], 0) }} kcal</p>
                </div>
                <div>
                    <p class="text-blue-200 text-sm">Protein</p>
                    <p class="text-2xl font-bold">{{ number_format($nutrition['weekly_total']['protein'], 1) }}g</p>
                </div>
                <div>
                    <p class="text-blue-200 text-sm">Lemak</p>
                    <p class="text-2xl font-bold">{{ number_format($nutrition['weekly_total']['fat'], 1) }}g</p>
                </div>
                <div>
                    <p class="text-blue-200 text-sm">Karbohidrat</p>
                    <p class="text-2xl font-bold">{{ number_format($nutrition['weekly_total']['carbohydrate'], 1) }}g</p>
                </div>
                <div>
                    <p class="text-blue-200 text-sm">Serat</p>
                    <p class="text-2xl font-bold">{{ number_format($nutrition['weekly_total']['fiber'], 1) }}g</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
