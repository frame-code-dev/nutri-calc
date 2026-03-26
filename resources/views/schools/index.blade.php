<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Penerima Manfaat</h2>
                <p class="text-sm text-gray-500 mt-1">Kelola data penerima manfaat dan koordinator</p>
            </div>
            <a href="{{ route('schools.create') }}"
                class="flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all shadow-sm hover:shadow-md">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Penerima Manfaat
            </a>
        </div>
        <!-- Search & Filter -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <form method="GET" action="{{ route('schools.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cari Sekolah</label>
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Nama atau alamat..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif
                        </option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Statistics Summary Card -->
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden mb-6">
            <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-900">Total Keseluruhan (Sekolah + Posyandu)</h3>
            </div>
            <div class="p-4 grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Porsi Kecil</p>
                    <h3 class="text-2xl font-black text-gray-900">{{ number_format($totals['grand']['small_portions']) }}</h3>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Porsi Besar</p>
                    <h3 class="text-2xl font-black text-gray-900">{{ number_format($totals['grand']['large_portions']) }}</h3>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Guru & Kader</p>
                    <h3 class="text-2xl font-black text-gray-900">{{ number_format($totals['grand']['teachers']) }}</h3>
                </div>
                <div>
                    <p class="text-xs font-bold text-green-600 uppercase tracking-widest">Total Keseluruhan</p>
                    <h3 class="text-2xl font-black text-green-600">{{ number_format($totals['grand']['overall']) }}</h3>
                </div>
            </div>

            <!-- Breakdown -->
            <div class="grid grid-cols-1 md:grid-cols-2 bg-gray-50 border-t border-gray-200">
                <!-- Sekolah -->
                <div class="p-4 border-b md:border-b-0 md:border-r border-gray-200">
                    <h4 class="text-sm font-bold text-gray-700 mb-3 uppercase tracking-wider">Total Data Sekolah</h4>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase">Kecil</p>
                            <p class="text-lg font-bold text-gray-800">{{ number_format($totals['school']['small_portions']) }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase">Besar</p>
                            <p class="text-lg font-bold text-gray-800">{{ number_format($totals['school']['large_portions']) }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase">Guru</p>
                            <p class="text-lg font-bold text-gray-800">{{ number_format($totals['school']['teachers']) }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-blue-500 uppercase">Total</p>
                            <p class="text-lg font-bold text-blue-600">{{ number_format($totals['school']['overall']) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Posyandu -->
                <div class="p-4">
                    <h4 class="text-sm font-bold text-gray-700 mb-3 uppercase tracking-wider">Total Data Posyandu</h4>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase">Kecil</p>
                            <p class="text-lg font-bold text-gray-800">{{ number_format($totals['posyandu']['small_portions']) }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase">Besar</p>
                            <p class="text-lg font-bold text-gray-800">{{ number_format($totals['posyandu']['large_portions']) }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase">Kader</p>
                            <p class="text-lg font-bold text-gray-800">{{ number_format($totals['posyandu']['teachers']) }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-blue-500 uppercase">Total</p>
                            <p class="text-lg font-bold text-blue-600">{{ number_format($totals['posyandu']['overall']) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Schools List -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Penerima Manfaat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Alamat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Porsi Kecil</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Porsi Besar</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Guru</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total (Porsi)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Koordinator</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($schools as $school)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 flex items-center gap-2">
                                        {{ $school->name }}
                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold tracking-wider uppercase {{ $school->type === 'posyandu' ? 'bg-pink-100 text-pink-700' : 'bg-blue-100 text-blue-700' }}">
                                            {{ $school->type }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-600">{{ Str::limit($school->address, 50) }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-semibold text-gray-900">
                                        {{ number_format($school->small_portion_count) }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-semibold text-gray-900">
                                        {{ number_format($school->large_portion_count) }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-semibold text-gray-900">
                                        {{ number_format($school->teacher_count) }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-blue-600">
                                        {{ number_format($school->small_portion_count + $school->large_portion_count) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-600">{{ $school->coordinators_count }} orang</div>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($school->is_active)
                                        <span
                                            class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Aktif
                                        </span>
                                    @else
                                        <span
                                            class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-1">
                                        <a href="{{ route('schools.show', $school) }}"
                                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                            title="Detail">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('schools.edit', $school) }}"
                                            class="p-2 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors"
                                            title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('schools.toggle-status', $school) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="p-2 {{ $school->is_active ? 'text-orange-600 hover:bg-orange-50' : 'text-green-600 hover:bg-green-50' }} rounded-lg transition-colors"
                                                title="{{ $school->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                @if ($school->is_active)
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                    </svg>
                                                @else
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                @endif
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-500">Tidak ada sekolah ditemukan</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($schools->hasPages())
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $schools->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
