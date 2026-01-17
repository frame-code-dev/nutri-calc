<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $rawMaterial->name }}</h2>
                <p class="mt-1 text-sm text-gray-600">Detail informasi bahan baku</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('raw-materials.edit', $rawMaterial) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('raw-materials.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg font-medium">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Material Info Card -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">Informasi Bahan Baku</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Nama Bahan</label>
                        <p class="mt-1 text-base text-gray-900">{{ $rawMaterial->name }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Satuan</label>
                        <p class="mt-1 text-base text-gray-900">{{ $rawMaterial->unit }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Kategori</label>
                        <p class="mt-1 text-base text-blue-600 font-bold tracking-tight">{{ $rawMaterial->category?->name ?: '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Status</label>
                        <p class="mt-1">
                            @if($rawMaterial->is_active)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                    Nonaktif
                                </span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nutrition Facts Card -->
        @if($rawMaterial->nutrition)
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">📊 Informasi Nilai Gizi (per 100g/100ml)</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-center">
                        <div class="text-sm text-yellow-600 font-medium mb-1">Energi</div>
                        <div class="text-2xl font-bold text-yellow-900">{{ number_format($rawMaterial->nutrition->energy_per_100g, 1) }}</div>
                        <div class="text-xs text-yellow-600 mt-1">kcal</div>
                    </div>
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
                        <div class="text-sm text-red-600 font-medium mb-1">Protein</div>
                        <div class="text-2xl font-bold text-red-900">{{ number_format($rawMaterial->nutrition->protein_per_100g, 1) }}</div>
                        <div class="text-xs text-red-600 mt-1">gram</div>
                    </div>
                    <div class="bg-orange-50 border border-orange-200 rounded-lg p-4 text-center">
                        <div class="text-sm text-orange-600 font-medium mb-1">Lemak</div>
                        <div class="text-2xl font-bold text-orange-900">{{ number_format($rawMaterial->nutrition->fat_per_100g, 1) }}</div>
                        <div class="text-xs text-orange-600 mt-1">gram</div>
                    </div>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
                        <div class="text-sm text-blue-600 font-medium mb-1">Karbohidrat</div>
                        <div class="text-2xl font-bold text-blue-900">{{ number_format($rawMaterial->nutrition->carbohydrate_per_100g, 1) }}</div>
                        <div class="text-xs text-blue-600 mt-1">gram</div>
                    </div>
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                        <div class="text-sm text-green-600 font-medium mb-1">Serat</div>
                        <div class="text-2xl font-bold text-green-900">{{ number_format($rawMaterial->nutrition->fiber_per_100g, 1) }}</div>
                        <div class="text-xs text-green-600 mt-1">gram</div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Stock Information -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Stok Saat Ini</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($rawMaterial->getCurrentStock()) }}</p>
                        <p class="text-xs text-gray-500">{{ $rawMaterial->unit }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Masuk</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($rawMaterial->stocks->where('type', 'in')->sum('quantity')) }}</p>
                        <p class="text-xs text-gray-500">{{ $rawMaterial->unit }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-red-100 rounded-lg p-3">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Keluar</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($rawMaterial->stocks->where('type', 'out')->sum('quantity')) }}</p>
                        <p class="text-xs text-gray-500">{{ $rawMaterial->unit }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Used in Menus -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">Digunakan dalam Menu</h3>
            </div>
            <div class="p-6">
                @if($rawMaterial->menuItems->isEmpty())
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">Bahan ini belum digunakan dalam menu manapun</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($rawMaterial->menuItems->unique('menu_id') as $menuItem)
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900">{{ $menuItem->menu->name }}</h4>
                                        <p class="text-sm text-gray-600 mt-1">
                                            {{ number_format($menuItem->quantity_per_portion) }} {{ $rawMaterial->unit }} per porsi
                                        </p>
                                        <span class="mt-2 inline-block px-2 py-1 text-xs font-medium rounded 
                                            {{ $menuItem->menu->type === 'wet' ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-700' }}">
                                            {{ $menuItem->menu->type === 'wet' ? 'Basah' : 'Kering' }}
                                        </span>
                                    </div>
                                    <a href="{{ route('menus.show', $menuItem->menu) }}" class="ml-2 text-blue-600 hover:text-blue-800">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Stock Movement History -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">Riwayat Pergerakan Stok</h3>
            </div>
            <div class="overflow-x-auto">
                @if($rawMaterial->stocks->isEmpty())
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">Belum ada riwayat pergerakan stok</p>
                    </div>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Quantity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Supplier</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Catatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($rawMaterial->stocks->sortByDesc('transaction_date')->take(10) as $stock)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $stock->transaction_date->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($stock->type === 'in')
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Masuk</span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">Keluar</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                        <span class="font-medium {{ $stock->type === 'in' ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $stock->type === 'in' ? '+' : '-' }}{{ number_format($stock->quantity) }}
                                        </span>
                                        <span class="text-gray-500 ml-1">{{ $rawMaterial->unit }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $stock->supplier->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $stock->notes ?? '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
            @if($rawMaterial->stocks->count() > 10)
                <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
                    <a href="{{ route('stocks.index', ['material_id' => $rawMaterial->id]) }}" class="text-sm text-blue-600 hover:text-blue-800">
                        Lihat Seluruh Riwayat →
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
