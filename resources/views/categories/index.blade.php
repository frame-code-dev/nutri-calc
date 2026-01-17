<x-app-layout>
    <div class="py-10 bg-gray-50 flex-1">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl space-y-6">
            <!-- Header section -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Kategori Bahan</h2>
                    <p class="text-sm text-gray-500 mt-1">Kelola pengelompokan bahan baku untuk mempermudah inventarisasi.</p>
                </div>
                <div>
                    <a href="{{ route('categories.create') }}" class="inline-flex items-center gap-2 px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-500/20 transition-all transform active:scale-95 group">
                        <svg class="w-4 h-4 text-blue-200 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Kategori
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-6 py-4 rounded-2xl flex items-center gap-3 animate-in fade-in slide-in-from-top-2 duration-300">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    <span class="text-sm font-bold tracking-tight">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-rose-50 border border-rose-100 text-rose-700 px-6 py-4 rounded-2xl flex items-center gap-3 animate-in fade-in slide-in-from-top-2 duration-300">
                    <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="text-sm font-bold tracking-tight">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Category List Table Card -->
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden min-h-[400px]">
                <div class="px-8 py-5 border-b border-gray-50 flex items-center justify-between bg-gray-50/30">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Daftar Kategori</h3>
                    <span class="px-3 py-1 bg-white border border-gray-100 rounded-lg text-[10px] font-bold text-gray-500 uppercase tracking-tight shadow-sm">{{ $categories->total() }} Total</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th scope="col" class="px-8 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Nama Kategori</th>
                                <th scope="col" class="px-8 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest truncate max-w-xs">Deskripsi</th>
                                <th scope="col" class="px-8 py-4 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest">Item Terkait</th>
                                <th scope="col" class="px-8 py-4 text-right text-[10px] font-bold text-gray-400 uppercase tracking-widest">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($categories as $category)
                                <tr class="group hover:bg-gray-50/50 transition-all duration-200">
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <div class="text-sm font-black text-gray-900 tracking-tight">{{ $category->name }}</div>
                                    </td>
                                    <td class="px-8 py-5">
                                        <div class="text-xs text-gray-500 line-clamp-1 max-w-xs truncate">{{ $category->description ?: '-' }}</div>
                                    </td>
                                    <td class="px-8 py-5 text-center">
                                        <span class="px-3 py-1 bg-blue-50 text-blue-600 text-[10px] font-bold rounded-lg border border-blue-100">
                                            {{ $category->raw_materials_count }} Item
                                        </span>
                                    </td>
                                    <td class="px-8 py-5 text-right whitespace-nowrap">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('categories.edit', $category) }}" 
                                               class="p-2 text-gray-400 hover:text-blue-600 bg-gray-50 hover:bg-blue-50 rounded-lg transition-all border border-transparent hover:border-blue-100">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="p-2 text-gray-400 hover:text-rose-600 bg-gray-50 hover:bg-rose-50 rounded-lg transition-all border border-transparent hover:border-rose-100">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-20 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 text-gray-200">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                            </div>
                                            <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">Belum ada kategori</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($categories->hasPages())
                    <div class="px-8 py-4 border-t border-gray-50 bg-gray-50/20">
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
