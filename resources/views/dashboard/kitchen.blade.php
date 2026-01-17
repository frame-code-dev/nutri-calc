<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            Dashboard Dapur - Produksi Besok
        </h2>
    </x-slot>

    <div class="space-y-6">
        <!-- Production Summary Card -->
        <div class="bg-gradient-to-r from-orange-500 to-red-500 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold mb-2">🍳 Produksi Besok</h3>
                    <p class="text-orange-100">{{ now()->addDay()->isoFormat('dddd, D MMMM YYYY') }}</p>
                </div>
                <div class="text-right">
                    <div class="bg-white bg-opacity-20 rounded-lg p-4">
                        <p class="text-sm text-orange-100">Total Sekolah</p>
                        <p class="text-4xl font-bold">{{ $tomorrowProduction->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Schools Production List -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Daftar Sekolah & Menu
                </h3>

                @if($tomorrowProduction->isEmpty())
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <p class="mt-2 text-gray-500">Tidak ada produksi untuk besok</p>
                        <p class="text-sm text-gray-400">Semua sekolah libur atau tidak menerima MBG</p>
                    </div>
                @else
                    <div class="space-y-3 max-h-[500px] overflow-y-auto">
                        @foreach($tomorrowProduction as $calendar)
                            <div class="p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg border border-blue-200">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900">{{ $calendar->school->name }}</h4>
                                        <p class="text-sm text-gray-600 mt-1">
                                            <span class="font-medium text-blue-700">{{ $calendar->menu->name ?? 'Menu tidak tersedia' }}</span>
                                        </p>
                                        @if($calendar->menu)
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ $calendar->menu->type === 'wet' ? '🍱 Menu Basah' : '📦 Menu Kering' }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="text-right ml-4">
                                        <div class="bg-orange-500 text-white px-3 py-1 rounded-full">
                                            <p class="text-xs font-medium">Porsi</p>
                                            <p class="text-lg font-bold">{{ $calendar->portion_count }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-700 font-medium">Total Porsi:</span>
                            <span class="text-2xl font-bold text-orange-600">
                                {{ number_format($tomorrowProduction->sum('portion_count')) }} porsi
                            </span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Material Needs -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    Kebutuhan Bahan Baku
                </h3>

                @if(empty($materialNeeds))
                    <div class="text-center py-8">
                        <p class="text-gray-500">Tidak ada kebutuhan bahan</p>
                    </div>
                @else
                    <div class="space-y-2 max-h-[500px] overflow-y-auto">
                        @foreach($materialNeeds as $need)
                            @php
                                $currentStock = $need['current_stock'];
                                $needed = $need['total_needed'];
                                $isLowStock = $currentStock < $needed;
                            @endphp
                            <div class="p-3 rounded-lg border {{ $isLowStock ? 'bg-red-50 border-red-300' : 'bg-green-50 border-green-200' }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <p class="font-medium {{ $isLowStock ? 'text-red-900' : 'text-gray-900' }}">
                                            {{ $need['material']->name }}
                                        </p>
                                        <p class="text-xs {{ $isLowStock ? 'text-red-600' : 'text-gray-600' }} mt-1">
                                            Stok: {{ number_format($currentStock) }} {{ $need['material']->unit }}
                                        </p>
                                    </div>
                                    <div class="text-right ml-4">
                                        <p class="text-sm text-gray-600">Butuh</p>
                                        <p class="text-lg font-bold {{ $isLowStock ? 'text-red-600' : 'text-green-600' }}">
                                            {{ number_format($needed) }}
                                        </p>
                                        <p class="text-xs text-gray-500">{{ $need['material']->unit }}</p>
                                    </div>
                                </div>
                                @if($isLowStock)
                                    <div class="mt-2 flex items-center text-red-600 text-xs">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        ⚠️ Stok tidak mencukupi! Kurang {{ number_format($needed - $currentStock) }} {{ $need['material']->unit }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('stocks.summary') }}" class="block text-center bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                            Lihat Semua Stok →
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">📋 Tindakan</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Print Daftar Produksi
                </button>
                
                <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                    Update Status Persiapan
                </button>

                <a href="{{ route('stocks.index') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-medium flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    Kelola Stok
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
