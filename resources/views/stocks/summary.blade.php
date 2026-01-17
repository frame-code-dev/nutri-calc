<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            📊 Ringkasan Stok Bahan Baku
        </h2>
    </x-slot>

    <div class="space-y-6">
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="bg-blue-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Total Bahan</p>
                        <p class="text-2xl font-bold text-gray-900">{{ count($stockSummary) }}</p>
                    </div>
                </div>
            </div>

            @php
                $lowStockCount = collect($stockSummary)->filter(function($item) {
                    return $item['current_stock'] < 10000;
                })->count();
                $totalValue = collect($stockSummary)->sum('value');
            @endphp

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="bg-red-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Stok Rendah</p>
                        <p class="text-2xl font-bold text-red-600">{{ $lowStockCount }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6 md:col-span-2">
                <div class="flex items-center">
                    <div class="bg-green-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Total Nilai Stok</p>
                        <p class="text-2xl font-bold text-green-600">Rp {{ number_format($totalValue) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stock Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Detail Stok Per Bahan</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bahan Baku</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok Saat Ini</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai (Rp)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Terakhir Masuk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Terakhir Keluar</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($stockSummary as $item)
                            @php
                                $isLowStock = $item['current_stock'] < 10000;
                            @endphp
                            <tr class="hover:bg-gray-50 {{ $isLowStock ? 'bg-red-50' : '' }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $item['material']->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $item['material']->unit }} @ Rp {{ number_format($item['material']->price_per_unit) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="text-sm font-bold {{ $isLowStock ? 'text-red-600' : 'text-green-600' }}">
                                            {{ number_format($item['current_stock']) }} {{ $item['unit'] }}
                                        </div>
                                        @if($isLowStock)
                                            <span class="ml-2 text-xs bg-red-100 text-red-800 px-2 py-1 rounded-full">⚠️ Rendah</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">Rp {{ number_format($item['value']) }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($item['last_in'])
                                        <div class="text-sm text-gray-900">{{ $item['last_in']->transaction_date->format('d M Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ number_format($item['last_in']->quantity) }} {{ $item['unit'] }}</div>
                                    @else
                                        <span class="text-sm text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($item['last_out'])
                                        <div class="text-sm text-gray-900">{{ $item['last_out']->transaction_date->format('d M Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ number_format($item['last_out']->quantity) }} {{ $item['unit'] }}</div>
                                    @else
                                        <span class="text-sm text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right text-sm font-medium">
                                    <a href="{{ route('raw-materials.show', $item['material']) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="flex justify-end space-x-3">
            <a href="{{ route('stocks.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium">
                📋 Lihat Semua Transaksi
            </a>
            <a href="{{ route('stocks.create', ['type' => 'in']) }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium">
                ➕ Tambah Stok Masuk
            </a>
        </div>
    </div>
</x-app-layout>
