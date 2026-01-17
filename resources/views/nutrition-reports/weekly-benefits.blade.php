<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Laporan Manfaat Mingguan</h2>
                <p class="mt-1 text-sm text-gray-600">Minggu {{ $weekNumber }}, {{ $year }} - Semua Sekolah</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('nutrition-reports.weekly-benefits', ['week_number' => $weekNumber, 'year' => $year, 'format' => 'pdf']) }}" 
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
        <!-- System-Wide Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg p-6 text-white">
                <div class="flex items-center justify-between mb-2">
                    <svg class="w-12 h-12 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <p class="text-blue-100 text-sm">Sekolah Menerima</p>
                <p class="text-3xl font-bold">{{ $schools->count() }}</p>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg p-6 text-white">
                <div class="flex items-center justify-between mb-2">
                    <svg class="w-12 h-12 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <p class="text-green-100 text-sm">Total Siswa</p>
                <p class="text-3xl font-bold">{{ number_format($benefits['total_students']) }}</p>
            </div>

            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg p-6 text-white">
                <div class="flex items-center justify-between mb-2">
                    <svg class="w-12 h-12 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-purple-100 text-sm">Hari Aktif</p>
                <p class="text-3xl font-bold">{{ $benefits['active_days'] }}</p>
            </div>

            <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg p-6 text-white">
                <div class="flex items-center justify-between mb-2">
                    <svg class="w-12 h-12 text-orange-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <p class="text-orange-100 text-sm">Total Porsi</p>
                <p class="text-3xl font-bold">{{ number_format($benefits['total_portions']) }}</p>
            </div>
        </div>

        <!-- Total Nutrition Provided -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Total Gizi yang Diberikan</h3>
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <!-- Energy -->
                <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 border-2 border-yellow-200 rounded-xl p-6 text-center">
                    <div class="text-sm font-medium text-yellow-600 mb-2">Total Energi</div>
                    <div class="text-3xl font-bold text-yellow-900">{{ number_format($benefits['total_nutrition']['energy'], 0) }}</div>
                    <div class="text-xs text-yellow-700 mt-1">kcal</div>
                    <div class="mt-3 text-xs text-yellow-600">
                        Rata-rata: {{ number_format($benefits['average_per_student']['energy'], 0) }} kcal/siswa
                    </div>
                </div>

                <!-- Protein -->
                <div class="bg-gradient-to-br from-red-50 to-red-100 border-2 border-red-200 rounded-xl p-6 text-center">
                    <div class="text-sm font-medium text-red-600 mb-2">Total Protein</div>
                    <div class="text-3xl font-bold text-red-900">{{ number_format($benefits['total_nutrition']['protein'], 1) }}</div>
                    <div class="text-xs text-red-700 mt-1">gram</div>
                    <div class="mt-3 text-xs text-red-600">
                        Rata-rata: {{ number_format($benefits['average_per_student']['protein'], 1) }}g/siswa
                    </div>
                </div>

                <!-- Fat -->
                <div class="bg-gradient-to-br from-orange-50 to-orange-100 border-2 border-orange-200 rounded-xl p-6 text-center">
                    <div class="text-sm font-medium text-orange-600 mb-2">Total Lem ak</div>
                    <div class="text-3xl font-bold text-orange-900">{{ number_format($benefits['total_nutrition']['fat'], 1) }}</div>
                    <div class="text-xs text-orange-700 mt-1">gram</div>
                    <div class="mt-3 text-xs text-orange-600">
                        Rata-rata: {{ number_format($benefits['average_per_student']['fat'], 1) }}g/siswa
                    </div>
                </div>

                <!-- Carbohydrate -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200 rounded-xl p-6 text-center">
                    <div class="text-sm font-medium text-blue-600 mb-2">Total Karbohidrat</div>
                    <div class="text-3xl font-bold text-blue-900">{{ number_format($benefits['total_nutrition']['carbohydrate'], 1) }}</div>
                    <div class="text-xs text-blue-700 mt-1">gram</div>
                    <div class="mt-3 text-xs text-blue-600">
                        Rata-rata: {{ number_format($benefits['average_per_student']['carbohydrate'], 1) }}g/siswa
                    </div>
                </div>

                <!-- Fiber -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 border-2 border-green-200 rounded-xl p-6 text-center">
                    <div class="text-sm font-medium text-green-600 mb-2">Total Serat</div>
                    <div class="text-3xl font-bold text-green-900">{{ number_format($benefits['total_nutrition']['fiber'], 1) }}</div>
                    <div class="text-xs text-green-700 mt-1">gram</div>
                    <div class="mt-3 text-xs text-green-600">
                        Rata-rata: {{ number_format($benefits['average_per_student']['fiber'], 1) }}g/siswa
                    </div>
                </div>
            </div>
        </div>

        <!-- Schools Breakdown -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Rincian Per Sekolah</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sekolah</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Jumlah Siswa</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Hari Menerima</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total Porsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($schools as $school)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $school->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $school->address }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-right font-medium text-gray-900">
                                    {{ number_format($school->student_count) }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ $school->receive_count }} hari
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-right font-semibold text-blue-600">
                                    {{ number_format($school->student_count * $school->receive_count) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
