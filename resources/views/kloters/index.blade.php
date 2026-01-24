<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-6">
        <div class="max-w-7xl mx-auto sm:px-6 space-y-8">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Setting Kloter</h2>
                    <p class="text-sm text-gray-500 mt-1">Kelola pengelompokan sekolah untuk distribusi makanan</p>
                </div>
                <a href="{{ route('kloters.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Kloter
                </a>
            </div>

            <!-- Kloters List -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @forelse($kloters as $kloter)
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-gray-900">{{ $kloter->name }}</h3>
                                    @if($kloter->date)
                                        <p class="text-xs text-gray-500 mt-1">{{ $kloter->date->format('d M Y') }}</p>
                                    @endif
                                </div>
                                <span class="px-2 py-1 text-xs font-bold rounded-lg {{ $kloter->is_active ? 'bg-green-50 text-green-700' : 'bg-gray-50 text-gray-500' }}">
                                    {{ $kloter->is_active ? 'Aktif' : 'Non-aktif' }}
                                </span>
                            </div>

                            @if($kloter->description)
                                <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $kloter->description }}</p>
                            @endif

                            <div class="flex items-center gap-2 mb-4 pb-4 border-b border-gray-100">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                <span class="text-sm font-semibold text-gray-700">{{ $kloter->schools_count }} Sekolah</span>
                            </div>

                            <div class="flex items-center gap-2">
                                <a href="{{ route('kloters.show', $kloter) }}" class="flex-1 text-center px-3 py-2 bg-gray-50 text-gray-700 text-xs font-semibold rounded-lg hover:bg-gray-100 transition-all">
                                    Lihat Detail
                                </a>
                                <a href="{{ route('kloters.edit', $kloter) }}" class="flex-1 text-center px-3 py-2 bg-blue-50 text-blue-700 text-xs font-semibold rounded-lg hover:bg-blue-100 transition-all">
                                    Edit
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-2xl border border-gray-100 p-12 text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-gray-50 rounded-full mb-3">
                            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <p class="text-sm font-bold text-gray-400">Belum ada kloter</p>
                        <p class="text-xs text-gray-300 mt-1">Klik "Tambah Kloter" untuk membuat kelompok sekolah baru</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
