<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Laporan Gizi Menu</h2>
                <p class="mt-1 text-sm text-gray-600">{{ $menu->name }}</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('nutrition-reports.menu', ['menu' => $menu->id, 'format' => 'pdf']) }}" 
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
        <!-- Menu Info -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Menu</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="text-sm font-medium text-gray-500">Nama Menu</label>
                    <p class="mt-1 text-base text-gray-900">{{ $menu->name }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">Jenis</label>
                    <p class="mt-1">
                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $menu->type === 'wet' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $menu->type === 'wet' ? 'Basah' : 'Kering' }}
                        </span>
                    </p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">Status</label>
                    <p class="mt-1">
                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $menu->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $menu->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Nutrition Values -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Kandungan Gizi (per porsi)</h3>
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <!-- Energy -->
                <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 border-2 border-yellow-200 rounded-xl p-6 text-center">
                    <div class="w-12 h-12 bg-yellow-500 rounded-full mx-auto mb-3 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="text-sm font-medium text-yellow-600 mb-1">Energi</div>
                    <div class="text-3xl font-bold text-yellow-900">{{ number_format($nutrition['energy'], 1) }}</div>
                    <div class="text-xs text-yellow-700 mt-1">kcal</div>
                </div>

                <!-- Protein -->
                <div class="bg-gradient-to-br from-red-50 to-red-100 border-2 border-red-200 rounded-xl p-6 text-center">
                    <div class="w-12 h-12 bg-red-500 rounded-full mx-auto mb-3 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="text-sm font-medium text-red-600 mb-1">Protein</div>
                    <div class="text-3xl font-bold text-red-900">{{ number_format($nutrition['protein'], 1) }}</div>
                    <div class="text-xs text-red-700 mt-1">gram</div>
                </div>

                <!-- Fat -->
                <div class="bg-gradient-to-br from-orange-50 to-orange-100 border-2 border-orange-200 rounded-xl p-6 text-center">
                    <div class="w-12 h-12 bg-orange-500 rounded-full mx-auto mb-3 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z"/>
                            <path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="text-sm font-medium text-orange-600 mb-1">Lemak</div>
                    <div class="text-3xl font-bold text-orange-900">{{ number_format($nutrition['fat'], 1) }}</div>
                    <div class="text-xs text-orange-700 mt-1">gram</div>
                </div>

                <!-- Carbohydrate -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200 rounded-xl p-6 text-center">
                    <div class="w-12 h-12 bg-blue-500 rounded-full mx-auto mb-3 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2a1 1 0 000 2h6a1 1 0 100-2H7zm6 7a1 1 0 011 1v3a1 1 0 11-2 0v-3a1 1 0 011-1zm-3 3a1 1 0 100 2h.01a1 1 0 100-2H10zm-4 1a1 1 0 011-1h.01a1 1 0 110 2H7a1 1 0 01-1-1zm1-4a1 1 0 100 2h.01a1 1 0 100-2H7zm2 1a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1zm4-4a1 1 0 100 2h.01a1 1 0 100-2H13zM9 9a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1zM7 8a1 1 0 000 2h.01a1 1 0 000-2H7z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="text-sm font-medium text-blue-600 mb-1">Karbohidrat</div>
                    <div class="text-3xl font-bold text-blue-900">{{ number_format($nutrition['carbohydrate'], 1) }}</div>
                    <div class="text-xs text-blue-700 mt-1">gram</div>
                </div>

                <!-- Fiber -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 border-2 border-green-200 rounded-xl p-6 text-center">
                    <div class="w-12 h-12 bg-green-500 rounded-full mx-auto mb-3 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="text-sm font-medium text-green-600 mb-1">Serat</div>
                    <div class="text-3xl font-bold text-green-900">{{ number_format($nutrition['fiber'], 1) }}</div>
                    <div class="text-xs text-green-700 mt-1">gram</div>
                </div>
            </div>
        </div>

        <!-- Ingredients -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Komposisi Bahan</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bahan</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Quantity</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Energi</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Protein</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Lemak</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Karbohidrat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($menu->menuItems as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $item->rawMaterial->name }}</td>
                                <td class="px-6 py-4 text-sm text-right text-gray-900 font-medium">
                                    {{ number_format($item->quantity_per_portion) }} {{ $item->rawMaterial->unit }}
                                </td>
                                <td class="px-6 py-4 text-sm text-right text-gray-600">
                                    {{ number_format($item->rawMaterial->nutrition->energy_per_100g ?? 0, 1) }} kcal
                                </td>
                                <td class="px-6 py-4 text-sm text-right text-gray-600">
                                    {{ number_format($item->rawMaterial->nutrition->protein_per_100g ?? 0, 1) }}g
                                </td>
                                <td class="px-6 py-4 text-sm text-right text-gray-600">
                                    {{ number_format($item->rawMaterial->nutrition->fat_per_100g ?? 0, 1) }}g
                                </td>
                                <td class="px-6 py-4 text-sm text-right text-gray-600">
                                    {{ number_format($item->rawMaterial->nutrition->carbohydrate_per_100g ?? 0, 1) }}g
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
