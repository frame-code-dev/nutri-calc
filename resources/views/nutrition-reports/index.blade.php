<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            📊 Laporan Kandungan Gizi
        </h2>
    </x-slot>

    <div class="space-y-6">
        <!-- Report Types -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Menu Nutrition Report -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Laporan Per Menu</h3>
                <p class="text-sm text-gray-600 mb-4">Lihat kandungan gizi untuk menu tertentu</p>
                
                <form action="{{ route('nutrition-reports.menu', ['menu' => 1]) }}" method="GET" class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Menu</label>
                        <select name="menu_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="">-- Pilih Menu --</option>
                            @foreach($menus as $menu)
                                <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                        Lihat Laporan
                    </button>
                </form>
            </div>

            <!-- School Weekly Report -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="bg-green-100 rounded-full w-16 h-16 flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Laporan Per Sekolah</h3>
                <p class="text-sm text-gray-600 mb-4">Gizi mingguan untuk sekolah tertentu</p>
                
                <form action="{{ route('nutrition-reports.school-weekly') }}" method="GET" class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Sekolah</label>
                        <select name="school_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
                            <option value="">-- Pilih Sekolah --</option>
                            @foreach($schools as $school)
                                <option value="{{ $school->id }}">{{ $school->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Minggu</label>
                            <input type="number" name="week_number" min="1" max="53" value="{{ now()->isoWeek }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                            <input type="number" name="year" min="2024" max="2030" value="{{ now()->year }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                        Lihat Laporan
                    </button>
                </form>
            </div>

            <!-- Weekly Benefits Report -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="bg-purple-100 rounded-full w-16 h-16 flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Manfaat Mingguan</h3>
                <p class="text-sm text-gray-600 mb-4">Total gizi semua sekolah per minggu</p>
                
                <form action="{{ route('nutrition-reports.weekly-benefits') }}" method="GET" class="space-y-3">
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Minggu</label>
                            <input type="number" name="week_number" min="1" max="53" value="{{ now()->addWeek()->isoWeek }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                            <input type="number" name="year" min="2024" max="2030" value="{{ now()->year }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500" required>
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                        Lihat Laporan
                    </button>
                </form>
            </div>
        </div>

        <!-- Menu Comparison -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">🔍 Perbandingan Menu</h3>
            <p class="text-sm text-gray-600 mb-4">Bandingkan kandungan gizi dari beberapa menu sekaligus</p>
            
            <form action="{{ route('nutrition-reports.compare-menus') }}" method="GET" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Menu (minimal 2)</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 max-h-60 overflow-y-auto border border-gray-200 rounded-lg p-4">
                        @foreach($menus as $menu)
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="menu_ids[]" value="{{ $menu->id }}" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-gray-700">{{ $menu->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-2 rounded-lg font-medium">
                    Bandingkan Menu
                </button>
            </form>
        </div>

        <!-- Information Box -->
        <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        <strong>Info:</strong> Semua laporan dapat diexport ke format PDF untuk dokumentasi dan presentasi. 
                        Klik tombol "Download PDF" setelah melihat laporan.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
