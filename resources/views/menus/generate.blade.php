<x-app-layout>
    <div class="py-10 bg-gray-50 flex-1">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl space-y-6">
            <!-- Header section -->
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Generate Menu Hari / Paket</h2>
                    <p class="text-sm text-gray-500 mt-1">Gabungkan beberapa menu master menjadi satu menu paket (Ompren).</p>
                </div>
                <a href="{{ route('menus.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-600 text-sm font-semibold rounded-xl hover:bg-gray-50 transition-all shadow-sm">
                    Kembali
                </a>
            </div>

            <form action="{{ route('menus.generate.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Info -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="name" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nama Menu Paket <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/10 focus:border-blue-500" placeholder="Contoh: Paket Senin (Ayam Teriyaki)">
                        </div>
                        <div>
                            <label for="description" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Deskripsi</label>
                            <textarea name="description" id="description" rows="2" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/10 focus:border-blue-500" placeholder="Opsional"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Selection -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/50">
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Pilih Komponen Menu</h3>
                    </div>
                    <div class="p-6">
                        <!-- Search -->
                        <div class="mb-4 relative">
                            <input type="text" id="menuSearch" class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-sm" placeholder="Cari menu master...">
                            <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 max-h-96 overflow-y-auto pr-2 custom-scrollbar" id="menuGrid">
                            @foreach($menus as $menu)
                            <label class="menu-item relative flex items-start gap-3 p-3 rounded-xl border border-gray-100 bg-gray-50 cursor-pointer hover:border-blue-200 hover:bg-blue-50 transition-all select-none">
                                <input type="checkbox" name="menu_ids[]" value="{{ $menu->id }}" class="mt-1 rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200/50">
                                <div>
                                    <span class="block text-sm font-bold text-gray-700 name-text">{{ $menu->name }}</span>
                                    {{-- <span class="block text-xs text-gray-400 mt-0.5">{{ $menu->menuItems->count() }} Bahan</span> --}}
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-8 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-500/20 transition-all transform active:scale-95">
                        Generate Menu
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('menuSearch').addEventListener('input', function(e) {
            const val = e.target.value.toLowerCase();
            document.querySelectorAll('.menu-item').forEach(item => {
                const name = item.querySelector('.name-text').textContent.toLowerCase();
                if(name.includes(val)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
