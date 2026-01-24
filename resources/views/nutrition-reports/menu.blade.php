<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-1">
                    <a href="{{ route('nutrition-reports.index') }}" class="hover:text-blue-600 transition-colors">Laporan</a>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <span>Detail Menu</span>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight">{{ $menu->name }}</h2>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('nutrition-reports.index') }}" class="inline-flex items-center px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-700 font-semibold text-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200 transition-all shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali
                </a>
                <a href="{{ route('nutrition-reports.menu', ['menu' => $menu->id, 'format' => 'pdf']) }}" 
                   class="inline-flex items-center px-4 py-2.5 bg-red-600 border border-transparent rounded-xl text-white font-semibold text-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 shadow-lg shadow-red-500/30 transition-all">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Download PDF
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Menu Info & Nutrition Cards -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Nutrition Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Main Energy Card -->
                    <div class="md:col-span-2 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl shadow-lg p-6 text-white relative overflow-hidden">
                        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full blur-xl"></div>
                        <div class="relative z-10 flex items-center justify-between">
                            <div>
                                <p class="text-yellow-100 font-medium text-sm uppercase tracking-wider mb-1">Total Energi</p>
                                <div class="flex items-baseline gap-2">
                                    <span class="text-5xl font-black">{{ number_format($nutrition['energy'], 0) }}</span>
                                    <span class="text-xl font-bold text-yellow-100">kcal</span>
                                </div>
                                <p class="mt-2 text-sm text-yellow-50 opacity-90">Per satu porsi sajian</p>
                            </div>
                            <div class="p-4 bg-white/20 rounded-2xl backdrop-blur-sm">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Macro Nutrients -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col items-center text-center hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center text-red-500 mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                        </div>
                        <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">Protein</p>
                        <p class="text-3xl font-black text-gray-900 mt-1">{{ number_format($nutrition['protein'], 1) }}<span class="text-base text-gray-400 font-medium ml-1">g</span></p>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col items-center text-center hover:shadow-md transition-shadow">
                         <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-500 mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        </div>
                        <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">Karbohidrat</p>
                        <p class="text-3xl font-black text-gray-900 mt-1">{{ number_format($nutrition['carbohydrate'], 1) }}<span class="text-base text-gray-400 font-medium ml-1">g</span></p>
                    </div>

                     <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col items-center text-center hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center text-orange-500 mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                        <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">Lemak</p>
                        <p class="text-3xl font-black text-gray-900 mt-1">{{ number_format($nutrition['fat'], 1) }}<span class="text-base text-gray-400 font-medium ml-1">g</span></p>
                    </div>

                     <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col items-center text-center hover:shadow-md transition-shadow">
                         <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center text-green-500 mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">Serat</p>
                        <p class="text-3xl font-black text-gray-900 mt-1">{{ number_format($nutrition['fiber'], 1) }}<span class="text-base text-gray-400 font-medium ml-1">g</span></p>
                    </div>
                </div>

                <!-- Composition Table -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
                         <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Komposisi Bahan Baku</h3>
                         <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $menu->menuItems->count() }} Item
                        </span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50/50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Bahan</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Quantity</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Energi (kcal)</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Prot (g)</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Lemak (g)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach($menu->menuItems as $item)
                                    <tr class="hover:bg-blue-50/50 transition-colors">
                                        <td class="px-6 py-4 font-medium text-gray-900">{{ $item->rawMaterial->name }}</td>
                                        <td class="px-6 py-4 text-right text-gray-600">
                                            {{ number_format($item->quantity_per_portion) }} {{ $item->rawMaterial->unit }}
                                        </td>
                                        <td class="px-6 py-4 text-right text-gray-600">
                                            {{ number_format($item->rawMaterial->nutrition->energy_per_100g ?? 0, 1) }}
                                        </td>
                                        <td class="px-6 py-4 text-right text-gray-600">
                                            {{ number_format($item->rawMaterial->nutrition->protein_per_100g ?? 0, 1) }}
                                        </td>
                                        <td class="px-6 py-4 text-right text-gray-600">
                                            {{ number_format($item->rawMaterial->nutrition->fat_per_100g ?? 0, 1) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Column: Sidebar Info -->
            <div class="space-y-6">
                <!-- Status Panel -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4 leading-tight">Detail Status</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-2 border-b border-gray-50">
                            <span class="text-sm text-gray-600">Tipe Menu</span>
                             <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $menu->type === 'wet' ? 'bg-indigo-100 text-indigo-700' : 'bg-orange-100 text-orange-700' }}">
                                {{ $menu->type === 'wet' ? 'Menu Basah' : 'Menu Kering' }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-50">
                             <span class="text-sm text-gray-600">Status</span>
                             <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $menu->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $menu->is_active ? 'Aktif Digunakan' : 'Diarsipkan' }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-50">
                            <span class="text-sm text-gray-600">Total Bahan</span>
                            <span class="text-sm font-bold text-gray-900">{{ $menu->menuItems->count() }} Jenis</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-sm text-gray-600">Dibuat Pada</span>
                            <span class="text-sm font-bold text-gray-900">{{ $menu->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Info Card -->
                <div class="bg-blue-50 rounded-2xl border border-blue-100 p-5">
                    <div class="flex gap-3">
                         <svg class="w-6 h-6 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                         <div class="text-xs text-blue-800 leading-relaxed">
                            <p class="mb-2 font-bold">Tentang Laporan Ini</p>
                            Nilai gizi dihitung berdasarkan akumulasi kandungan nutrisi dari setiap bahan baku yang digunakan (data per 100g). Nilai aktual dapat bervariasi tergantung pada proses memasak dan kualitas bahan baku spesifik dari supplier.
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
