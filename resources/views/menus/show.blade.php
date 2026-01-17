<x-app-layout>
    <div class="py-10 bg-gray-50 flex-1">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl space-y-6">
            <!-- Header section -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">
                        <a href="{{ route('menus.index') }}" class="hover:text-blue-600 transition-colors">Manajemen Menu</a>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        <span class="text-gray-900">Detail Menu</span>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 tracking-tight">{{ $menu->name }}</h2>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('menus.edit', $menu) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-50 transition-all shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Edit Menu
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column: Details & Ingredients -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Stats Card -->
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 grid grid-cols-2 sm:grid-cols-4 gap-6">
                        <div>
                            <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Jenis Menu</span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-tight {{ $menu->type === 'wet' ? 'bg-indigo-50 text-indigo-700 border border-indigo-100' : 'bg-orange-50 text-orange-700 border border-orange-100' }}">
                                {{ $menu->type === 'wet' ? 'Menu Basah' : 'Menu Kering' }}
                            </span>
                        </div>
                        <div>
                            <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Status</span>
                            <div class="flex items-center gap-1.5 mt-1">
                                <div class="w-2 h-2 rounded-full {{ $menu->is_active ? 'bg-green-500' : 'bg-red-500' }}"></div>
                                <span class="text-xs font-bold text-gray-700">{{ $menu->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                            </div>
                        </div>
                        <div>
                            <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Bahan</span>
                            <span class="text-sm font-bold text-gray-700">{{ $menu->menuItems->count() }} Item</span>
                        </div>
                        <div>
                            <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Dibuat</span>
                            <span class="text-sm font-bold text-gray-700">{{ $menu->created_at->format('d M Y') }}</span>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Deskripsi</h3>
                        <p class="text-sm text-gray-600 leading-relaxed font-medium">
                            {{ $menu->description ?: 'Tidak ada deskripsi tersedia untuk menu ini.' }}
                        </p>
                    </div>

                    <!-- Ingredients List -->
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/50">
                            <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Komposisi Bahan</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-100">
                                <thead>
                                    <tr class="bg-gray-50/30">
                                        <th scope="col" class="px-6 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Bahan Baku</th>
                                        <th scope="col" class="px-6 py-3 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest">Jumlah</th>
                                        <th scope="col" class="px-6 py-3 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest">Satuan</th>
                                        <th scope="col" class="px-6 py-3 text-right text-[10px] font-bold text-gray-400 uppercase tracking-widest">Kalori</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @php $nutrition = $menu->calculateNutrition(); @endphp
                                    @foreach($menu->menuItems as $item)
                                        @php
                                            $itemNutrition = $item->rawMaterial->nutrition;
                                            $energyContrib = $itemNutrition ? ($itemNutrition->energy_per_100g * $item->quantity_per_portion / 100) : 0;
                                        @endphp
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-semibold text-gray-900">{{ $item->rawMaterial->name }}</div>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <div class="text-sm font-bold text-gray-700">{{ number_format($item->quantity_per_portion, 2) }}</div>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <div class="text-[10px] font-bold text-gray-400 uppercase bg-gray-100 px-2 py-0.5 rounded-md inline-block">{{ $item->rawMaterial->unit }}</div>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <div class="text-sm font-bold text-orange-600">{{ number_format($energyContrib, 1) }} <span class="text-[10px] text-gray-400 font-medium ml-0.5">kkal</span></div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Nutrition Cards -->
                <div class="space-y-6">
                    <div class="bg-white rounded-3xl border-2 border-green-100 shadow-sm overflow-hidden">
                        <div class="bg-green-50 px-6 py-5 border-b border-green-100">
                            <h3 class="flex items-center gap-2 text-sm font-bold text-green-700 uppercase tracking-wider">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Ringkasan Gizi
                            </h3>
                            <p class="text-[10px] text-green-600/70 font-bold uppercase tracking-widest mt-1">Estimasi per porsi</p>
                        </div>
                        <div class="p-6 space-y-4">
                            <!-- Energy Highlight -->
                            <div class="bg-gradient-to-br from-orange-50 to-orange-100/50 p-6 rounded-2xl border border-orange-100 text-center">
                                <span class="block text-[10px] font-bold text-orange-400 uppercase tracking-widest mb-1">Energi Total</span>
                                <div class="flex items-baseline justify-center gap-1">
                                    <span class="text-4xl font-black text-orange-600 tracking-tight">{{ number_format($nutrition['energy'], 0) }}</span>
                                    <span class="text-sm font-bold text-orange-400 uppercase tracking-wider">kkal</span>
                                </div>
                            </div>
                            
                            <!-- Other Nutrients List -->
                            <div class="grid grid-cols-1 gap-3">
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl border border-gray-100">
                                    <div class="flex items-center gap-3">
                                        <div class="w-2 h-2 rounded-full bg-red-500"></div>
                                        <span class="text-sm font-bold text-gray-600">Protein</span>
                                    </div>
                                    <div class="flex items-baseline gap-1">
                                        <span class="text-lg font-black text-gray-900">{{ number_format($nutrition['protein'], 1) }}</span>
                                        <span class="text-[10px] font-bold text-gray-400 uppercase">g</span>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl border border-gray-100">
                                    <div class="flex items-center gap-3">
                                        <div class="w-2 h-2 rounded-full bg-yellow-500"></div>
                                        <span class="text-sm font-bold text-gray-600">Lemak</span>
                                    </div>
                                    <div class="flex items-baseline gap-1">
                                        <span class="text-lg font-black text-gray-900">{{ number_format($nutrition['fat'], 1) }}</span>
                                        <span class="text-[10px] font-bold text-gray-400 uppercase">g</span>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl border border-gray-100">
                                    <div class="flex items-center gap-3">
                                        <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                                        <span class="text-sm font-bold text-gray-600">Karbohidrat</span>
                                    </div>
                                    <div class="flex items-baseline gap-1">
                                        <span class="text-lg font-black text-gray-900">{{ number_format($nutrition['carbohydrate'], 1) }}</span>
                                        <span class="text-[10px] font-bold text-gray-400 uppercase">g</span>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl border border-gray-100">
                                    <div class="flex items-center gap-3">
                                        <div class="w-2 h-2 rounded-full bg-green-500"></div>
                                        <span class="text-sm font-bold text-gray-600">Serat</span>
                                    </div>
                                    <div class="flex items-baseline gap-1">
                                        <span class="text-lg font-black text-gray-900">{{ number_format($nutrition['fiber'], 1) }}</span>
                                        <span class="text-[10px] font-bold text-gray-400 uppercase">g</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100">
                            <p class="text-[10px] text-gray-400 leading-relaxed font-medium">
                                * Nilai gizi dihitung berdasarkan data referensi bahan baku mentah per 100g.
                            </p>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
                        <button type="button" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-rose-50 text-rose-600 text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-rose-600 hover:text-white transition-all"
                            onclick="if(confirm('Apakah Anda yakin ingin menghapus menu ini?')) { document.getElementById('delete-form').submit() }">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Hapus Menu Permanen
                        </button>
                        <form id="delete-form" action="{{ route('menus.destroy', $menu) }}" method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
