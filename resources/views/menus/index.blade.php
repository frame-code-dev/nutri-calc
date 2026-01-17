<x-app-layout>
    <div class="py-10 bg-gray-50 flex-1">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <!-- Header section -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Manajemen Menu</h2>
                    <p class="text-sm text-gray-500 mt-1">Kelola daftar menu makanan dan komposisi gizinya.</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('menus.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Menu
                    </a>
                </div>
            </div>

            <!-- Search & Filter Bar -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 sm:p-6">
                <form method="GET" action="{{ route('menus.index') }}" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama menu..." 
                            class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/10 focus:border-blue-500 transition-all font-medium">
                    </div>
                    <div class="w-full md:w-48">
                        <select name="type" class="block w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/10 focus:border-blue-500 transition-all font-semibold text-gray-700">
                            <option value="">Semua Jenis</option>
                            <option value="wet" {{ request('type') === 'wet' ? 'selected' : '' }}>Menu Basah</option>
                            <option value="dry" {{ request('type') === 'dry' ? 'selected' : '' }}>Menu Kering</option>
                        </select>
                    </div>
                    <button type="submit" class="inline-flex items-center justify-center px-6 py-2.5 bg-gray-900 hover:bg-black text-white text-sm font-semibold rounded-xl transition-all">
                        Filter
                    </button>
                    @if(request()->anyFilled(['search', 'type']))
                        <a href="{{ route('menus.index') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-semibold rounded-xl transition-all">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            <!-- Menus Table Card -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto overflow-y-hidden">
                    <table class="min-w-full divide-y divide-gray-100 table-fixed">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th scope="col" class="w-1/3 px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Informasi Menu</th>
                                <th scope="col" class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Jenis & Status</th>
                                <th scope="col" class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Nutrisi (per porsi)</th>
                                <th scope="col" class="px-6 py-4 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest">Bahan</th>
                                <th scope="col" class="relative px-6 py-4">
                                    <span class="sr-only">Aksi</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-50">
                            @forelse($menus as $menu)
                                <tr class="hover:bg-blue-50/30 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-all">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                </svg>
                                            </div>
                                            <div class="ml-4 truncate">
                                                <div class="text-sm font-bold text-gray-900 truncate">{{ $menu->name }}</div>
                                                <div class="text-[11px] text-gray-400 font-medium truncate mt-0.5">{{ $menu->description ?: 'Tidak ada deskripsi' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col gap-2">
                                            <div class="inline-flex w-fit items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-tight {{ $menu->type === 'wet' ? 'bg-indigo-50 text-indigo-700 border border-indigo-100' : 'bg-orange-50 text-orange-700 border border-orange-100' }}">
                                                {{ $menu->type === 'wet' ? 'Menu Basah' : 'Menu Kering' }}
                                            </div>
                                            <div class="flex items-center gap-1.5">
                                                <div class="w-1.5 h-1.5 rounded-full {{ $menu->is_active ? 'bg-green-500' : 'bg-red-500' }}"></div>
                                                <span class="text-[10px] font-bold uppercase tracking-tight {{ $menu->is_active ? 'text-green-600' : 'text-red-600' }}">
                                                    {{ $menu->is_active ? 'Aktif' : 'Nonaktif' }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php $nutrition = $menu->calculateNutrition(); @endphp
                                        <div class="flex items-center gap-3">
                                            <div class="flex flex-col">
                                                <span class="text-[9px] font-bold text-gray-400 uppercase tracking-tighter">Energi</span>
                                                <span class="text-xs font-bold text-gray-700">{{ number_format($nutrition['energy'], 0) }}<span class="text-[10px] font-medium text-gray-400 ml-0.5 whitespace-nowrap">kkal</span></span>
                                            </div>
                                            <div class="w-px h-6 bg-gray-100"></div>
                                            <div class="flex flex-col">
                                                <span class="text-[9px] font-bold text-gray-400 uppercase tracking-tighter">Protein</span>
                                                <span class="text-xs font-bold text-gray-700">{{ number_format($nutrition['protein'], 1) }}<span class="text-[10px] font-medium text-gray-400 ml-0.5 whitespace-nowrap">g</span></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="inline-flex items-center justify-center h-7 px-2.5 bg-gray-50 border border-gray-100 rounded-lg text-xs font-bold text-gray-600">
                                            {{ $menu->menuItems->count() }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <a href="{{ route('menus.show', $menu) }}" class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="Detail">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>
                                            <a href="{{ route('menus.edit', $menu) }}" class="p-1.5 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            <button type="button" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"
                                                onclick="if(confirm('Apakah Anda yakin ingin menghapus menu ini?')) { document.getElementById('delete-form-{{ $menu->id }}').submit() }" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                            <form id="delete-form-{{ $menu->id }}" action="{{ route('menus.destroy', $menu) }}" method="POST" class="hidden">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="h-12 w-12 bg-gray-50 rounded-full flex items-center justify-center text-gray-300 mb-3">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                            </div>
                                            <p class="text-sm font-bold text-gray-400">Tidak ada menu ditemukan</p>
                                            <p class="text-xs text-gray-300 mt-1">Coba sesuaikan kata kunci pencarian atau filter Anda.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination section -->
                @if($menus->hasPages())
                    <div class="bg-gray-50/50 px-6 py-4 border-t border-gray-100">
                        {{ $menus->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
