<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Dashboard Admin MBG</h2>
            <p class="mt-1 text-sm text-gray-600">Selamat datang kembali di sistem pengelolaan gizi.</p>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <!-- Total Sekolah -->
            <div class="bg-white rounded-lg border border-gray-200 p-5">
                <div class="flex items-center justify-between mb-2">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span class="text-xs font-medium text-green-600">+2%</span>
                </div>
                <p class="text-sm text-gray-600">Total Sekolah</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total_schools'] }}</p>
            </div>

            <!-- Total Siswa -->
            <div class="bg-white rounded-lg border border-gray-200 p-5">
                <div class="flex items-center justify-between mb-2">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span class="text-xs font-medium text-green-600">+120</span>
                </div>
                <p class="text-sm text-gray-600">Total Siswa</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($stats['total_students']) }}</p>
            </div>

            <!-- Total Menu -->
            <div class="bg-white rounded-lg border border-gray-200 p-5">
                <div class="flex items-center justify-between mb-2">
                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <p class="text-sm text-gray-600">Total Menu</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total_menus'] }}</p>
            </div>

            <!-- Bahan Baku -->
            <div class="bg-white rounded-lg border border-gray-200 p-5">
                <div class="flex items-center justify-between mb-2">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <p class="text-sm text-gray-600">Bahan Baku</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total_materials'] }}</p>
            </div>

            <!-- Total Users -->
            <div class="bg-white rounded-lg border border-gray-200 p-5">
                <div class="flex items-center justify-between mb-2">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <p class="text-sm text-gray-600">Total Users</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total_users'] }}</p>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Stock Trends Chart -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Tren Stok</h3>
                    <p class="text-sm text-gray-600">7 Hari Terakhir</p>
                </div>
                <div class="flex items-center justify-end gap-4 mb-4 text-sm">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        <span class="text-gray-600">Stok Masuk</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                        <span class="text-gray-600">Stok Keluar</span>
                    </div>
                </div>
                <div class="h-64">
                    <canvas id="stockTrendsChart"></canvas>
                </div>
            </div>

            <!-- Menu Distribution Chart -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Distribusi Menu</h3>
                    <p class="text-sm text-gray-600">Berdasarkan Jenis</p>
                </div>
                <div class="h-64 flex items-center justify-center">
                    <canvas id="menuDistributionChart"></canvas>
                </div>
                <div class="mt-4 flex items-center justify-center gap-6 text-sm">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                        <span class="text-gray-600">Menu Basah ({{ $menuDistribution['wet_percentage'] }}%)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-orange-400 rounded-full"></div>
                        <span class="text-gray-600">Menu Kering ({{ $menuDistribution['dry_percentage'] }}%)</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Transactions & Low Stock -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Stock Transactions -->
            <div class="bg-white rounded-lg border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Transaksi Stok Terbaru</h3>
                    <a href="{{ route('stocks.index') }}" class="text-sm text-blue-600 hover:text-blue-800">Lihat Semua</a>
                </div>
                <div class="p-4 space-y-3">
                    @forelse($recentStocks->take(5) as $stock)
                        <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors">
                            <div class="flex items-center gap-3">
                                @if($stock->type === 'in')
                                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                    </div>
                                @else
                                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                        </svg>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-medium text-gray-900">{{ $stock->rawMaterial->name }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ $stock->type === 'in' ? 'Masuk dari ' : 'Keluar untuk ' }}
                                        {{ $stock->supplier->name ?? 'Produksi' }} • {{ $stock->transaction_date->format('d M Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold {{ $stock->type === 'in' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $stock->type === 'in' ? '+' : '-' }}{{ number_format($stock->quantity) }} {{ $stock->rawMaterial->unit }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500">
                            <svg class="w-12 h-12 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <p class="text-sm">Belum ada transaksi</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Low Stock Alerts -->
            <div class="bg-white rounded-lg border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center gap-2">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900">Stok Menipis</h3>
                </div>
                <div class="p-4 space-y-3">
                    @forelse($lowStockMaterials->take(5) as $item)
                        <div class="p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">{{ $item['material']->name }}</p>
                                    <p class="text-sm text-gray-600 mt-1">
                                        Stok kritis! Mohon lakukan pemesanan ulang segera.
                                    </p>
                                </div>
                                <span class="text-lg font-bold text-red-600 ml-4">
                                    {{ number_format($item['current_stock']) }} {{ $item['material']->unit }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500">
                            <svg class="w-12 h-12 mx-auto text-green-400 mb-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-sm">Semua stok aman</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Stock Trends Chart
        const stockCtx = document.getElementById('stockTrendsChart').getContext('2d');
        new Chart(stockCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [
                    {
                        label: 'Stok Masuk',
                        data: {!! json_encode($stockInData) !!},
                        backgroundColor: 'rgb(34, 197, 94)',
                        borderRadius: 4,
                        barThickness: 20,
                    },
                    {
                        label: 'Stok Keluar',
                        data: {!! json_encode($stockOutData) !!},
                        backgroundColor: 'rgb(239, 68, 68)',
                        borderRadius: 4,
                        barThickness: 20,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: true,
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Menu Distribution Chart
        const menuCtx = document.getElementById('menuDistributionChart').getContext('2d');
        new Chart(menuCtx, {
            type: 'doughnut',
            data: {
                labels: ['Menu Basah', 'Menu Kering'],
                datasets: [{
                    data: [{{ $menuDistribution['wet'] }}, {{ $menuDistribution['dry'] }}],
                    backgroundColor: ['rgb(59, 130, 246)', 'rgb(251, 146, 60)'],
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = {{ $menuDistribution['wet'] + $menuDistribution['dry'] }};
                                const percentage = ((context.parsed / total) * 100).toFixed(0);
                                return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            },
            plugins: [{
                id: 'centerText',
                beforeDraw: function(chart) {
                    const {width, height, ctx} = chart;
                    ctx.restore();
                    const fontSize = (height / 114);
                    ctx.font = `${fontSize}em sans-serif`;
                    ctx.textBaseline = "middle";
                    
                    const total = {{ $menuDistribution['wet'] + $menuDistribution['dry'] }};
                    const text = total;
                    const textX = Math.round((width - ctx.measureText(text).width) / 2);
                    const textY = height / 2 - 10;
                    
                    ctx.fillStyle = '#111827';
                    ctx.font = `bold ${fontSize * 2}em sans-serif`;
                    ctx.fillText(text, textX, textY);
                    
                    ctx.fillStyle = '#6B7280';
                    ctx.font = `${fontSize * 0.8}em sans-serif`;
                    const labelText = 'ITEMS';
                    const labelX = Math.round((width - ctx.measureText(labelText).width) / 2);
                    ctx.fillText(labelText, labelX, textY + 25);
                    
                    ctx.save();
                }
            }]
        });
    </script>
    @endpush
</x-app-layout>
