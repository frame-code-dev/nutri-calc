<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-8">
        <!-- Header Section -->
        <div>
            <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Laporan Kandungan Gizi</h2>
            <p class="text-sm text-gray-500 mt-2">Analisis mendalam tentang nilai gizi menu, asupan mingguan sekolah, dan perbandingan nutrisi.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Menu Nutrition Report -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                <div class="p-8">
                    <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center mb-6 text-blue-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Laporan Per Menu</h3>
                    <p class="text-sm text-gray-500 mb-6 leading-relaxed">Analisis detail kandungan energi, protein, lemak, karbohidrat, dan serat untuk satu paket menu spesifik.</p>
                    
                    <form action="{{ route('nutrition-reports.menu', ['menu' => 1]) }}" method="GET" class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Pilih Menu</label>
                            <div class="relative">
                                <select name="menu_id" class="block w-full pl-4 pr-10 py-3 text-base border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-xl transition-shadow" required>
                                    <option value="">-- Pilih Menu --</option>
                                    @foreach($menus as $menu)
                                        <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-3 bg-blue-600 border border-transparent rounded-xl font-bold text-sm text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all shadow-lg shadow-blue-500/30">
                            Lihat Laporan Menu
                            <svg class="ml-2 -mr-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- School Weekly Report -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                <div class="p-8">
                    <div class="w-14 h-14 bg-green-50 rounded-2xl flex items-center justify-center mb-6 text-green-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Laporan Mingguan Sekolah</h3>
                    <p class="text-sm text-gray-500 mb-6 leading-relaxed">Rekapitulasi total asupan gizi yang diterima oleh siswa di sekolah tertentu dalam satu minggu.</p>
                    
                    <form action="{{ route('nutrition-reports.school-weekly') }}" method="GET" class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Pilih Sekolah</label>
                            <select name="school_id" class="block w-full pl-4 pr-10 py-3 text-base border-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-xl transition-shadow" required>
                                <option value="">-- Pilih Sekolah --</option>
                                @foreach($schools as $school)
                                    <option value="{{ $school->id }}">{{ $school->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Minggu</label>
                                <input type="number" name="week_number" min="1" max="53" value="{{ now()->isoWeek }}" class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Tahun</label>
                                <input type="number" name="year" min="2024" max="2030" value="{{ now()->year }}" class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm" required>
                            </div>
                        </div>
                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-3 bg-green-600 border border-transparent rounded-xl font-bold text-sm text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all shadow-lg shadow-green-500/30">
                            Lihat Laporan Mingguan
                            <svg class="ml-2 -mr-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Weekly Benefits Report -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                <div class="p-8">
                    <div class="w-14 h-14 bg-purple-50 rounded-2xl flex items-center justify-center mb-6 text-purple-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Manfaat Global</h3>
                    <p class="text-sm text-gray-500 mb-6 leading-relaxed">Agregasi total manfaat gizi yang telah didistribusikan ke seluruh sekolah dalam satu periode minggu.</p>
                    
                    <form action="{{ route('nutrition-reports.weekly-benefits') }}" method="GET" class="space-y-4">
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Minggu</label>
                                <input type="number" name="week_number" min="1" max="53" value="{{ now()->addWeek()->isoWeek }}" class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 sm:text-sm" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Tahun</label>
                                <input type="number" name="year" min="2024" max="2030" value="{{ now()->year }}" class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 sm:text-sm" required>
                            </div>
                        </div>
                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-3 bg-purple-600 border border-transparent rounded-xl font-bold text-sm text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all shadow-lg shadow-purple-500/30">
                            Lihat Laporan Manfaat
                             <svg class="ml-2 -mr-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Menu Comparison Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-8">
                <div class="flex items-center gap-4 mb-6">
                    <div class="p-3 bg-orange-50 rounded-xl text-orange-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16l2.879-2.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Perbandingan Menu</h3>
                        <p class="text-sm text-gray-500">Pilih beberapa menu untuk membandingkan kandungan gizinya secara head-to-head.</p>
                    </div>
                </div>
                
                <form action="{{ route('nutrition-reports.compare-menus') }}" method="GET">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-3">Pilih Menu (Centang minimal 2)</label>
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 p-6 bg-gray-50 rounded-2xl border border-gray-100 max-h-60 overflow-y-auto mb-6 custom-scrollbar">
                        @foreach($menus as $menu)
                            <label class="relative flex items-center p-3 rounded-xl border border-gray-200 bg-white hover:border-orange-200 hover:shadow-sm cursor-pointer transition-all">
                                <input type="checkbox" name="menu_ids[]" value="{{ $menu->id }}" class="h-5 w-5 text-orange-600 focus:ring-orange-500 border-gray-300 rounded focus:ring-offset-0">
                                <span class="ml-3 text-sm font-medium text-gray-700">{{ $menu->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    <div class="flex justify-end">
                         <button type="submit" class="inline-flex items-center justify-center px-8 py-3 bg-orange-600 border border-transparent rounded-xl font-bold text-sm text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all shadow-lg shadow-orange-500/30">
                            Bandingkan Menu Terpilih
                             <svg class="ml-2 -mr-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </button>
                    </div>
                </form>
            </div>
            
             <!-- Info Footer -->
            <div class="bg-blue-50/50 border-t border-blue-100 p-6 flex items-start gap-4">
                 <svg class="w-6 h-6 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="text-sm text-blue-800">
                    <p class="font-bold mb-1">Dokumentasi & Ekspor</p>
                    <p class="opacity-80">Semua laporan hasil analisis dapat diekspor ke dalam format PDF untuk keperluan arsip fisik maupun presentasi kepada pemangku kepentingan.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
